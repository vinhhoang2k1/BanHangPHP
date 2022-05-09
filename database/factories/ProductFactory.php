<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = 'Sản phẩm ' . $this->faker->text($this->faker->numberBetween(20, 40));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'category_id' => $this->faker->randomElement(Category::pluck('id')),
            'price' => $this->faker->randomNumber(),
            'quantity'  => $this->faker->numberBetween(10, 20),
            'short_content' => $this->faker->text,
            'description' => $this->faker->paragraph()
        ];
    }
}
