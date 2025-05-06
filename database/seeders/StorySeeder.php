<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Choice;
use App\Models\Story;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the JSON file
        $jsonPath = database_path('data/story.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('Story JSON file not found at: ' . $jsonPath);
            return;
        }
        
        $json = File::get($jsonPath);
        $data = json_decode($json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Error parsing JSON: ' . json_last_error_msg());
            return;
        }

        // Afficher la structure du JSON pour le débogage
        $this->command->info('JSON structure: ' . json_encode(array_keys($data)));
        
        // Créer l'histoire avec des valeurs par défaut si les champs nécessaires sont manquants
        $story = Story::create([
            'title' => $data['title'] ?? 'Histoire interactive',
            'description' => $data['description'] ?? 'Une histoire interactive',
        ]);
        
        $this->command->info('Created story: ' . $story->title);
        
        // Créer des chapitres s'ils existent dans le JSON
        if (isset($data['chapters']) && is_array($data['chapters'])) {
            $chapterMap = [];
            
            // Première passe : créer tous les chapitres
            foreach ($data['chapters'] as $index => $chapterData) {
                $chapter = Chapter::create([
                    'story_id' => $story->id,
                    'title' => $chapterData['title'] ?? "Chapitre " . ($index + 1),
                    'content' => $chapterData['content'] ?? "Contenu du chapitre " . ($index + 1),
                    'is_end' => !isset($chapterData['choices']) || empty($chapterData['choices'])
                ]);
                
                $chapterMap[$index] = $chapter->id;
            }
            
            $this->command->info('Created ' . count($chapterMap) . ' chapters');
            
            // Définir le premier chapitre
            if (!empty($chapterMap)) {
                $story->update(['first_chapter_id' => $chapterMap[0]]);
                $this->command->info('Set first chapter ID to: ' . $chapterMap[0]);
            }
            
            // Deuxième passe : créer tous les choix
            foreach ($data['chapters'] as $index => $chapterData) {
                if (isset($chapterData['choices']) && is_array($chapterData['choices'])) {
                    foreach ($chapterData['choices'] as $choiceData) {
                        if (isset($choiceData['next_chapter']) && isset($chapterMap[$choiceData['next_chapter']])) {
                            Choice::create([
                                'chapter_id' => $chapterMap[$index],
                                'next_chapter_id' => $chapterMap[$choiceData['next_chapter']],
                                'text' => $choiceData['text'] ?? 'Continuer'
                            ]);
                        }
                    }
                }
            }
        } else {
            $this->command->error('No chapters found in the JSON file. Creating a default chapter.');
            
            // Créer un chapitre par défaut si aucun n'est défini
            $chapter = Chapter::create([
                'story_id' => $story->id,
                'title' => 'Début de l\'histoire',
                'content' => 'Votre aventure commence ici...',
                'is_end' => true
            ]);
            
            $story->update(['first_chapter_id' => $chapter->id]);
        }
        
        $this->command->info('Story seeding completed!');
    }
}