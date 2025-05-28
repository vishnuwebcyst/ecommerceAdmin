<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $description = $this->faker->sentence;
        $content = "<h1 style='text-align: center'>{$title}</h1>";

        foreach ($this->faker->paragraphs(rand(2, 5)) as $paragraph) {
            $content .= "<p>". $paragraph ."</p>";
        }

        $author = $this->faker->userName;
        $image = $this->faker->imageUrl;

        return [
            'title' => $title,
            'description'=> $description,
            'content'=> $content,
            'author'=> $author,
            'image'=> $image,
        ];
    }
}
