<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Category\Models\Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
             'name_ar'           => $this->faker->name(),
            'name_en'           => $this->faker->name(),
            'slug'              => $this->faker->slug(),
            'description_ar'    => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'description_en'    => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'active'            => true,
            'icon'              => 'fas fa-truck-monster',//'icon_camera',
            'type'              => $this->faker->randomElement(['product','service'])
        ];
    }
}

