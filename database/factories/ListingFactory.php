<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created = $this->faker->dateTimeBetween('-2 years', 'now');
        $updated = $this->faker->dateTimeBetween($created, 'now');
        $oldPrice = $this->faker->randomFloat(2, 50000, 500000);
        $price = $this->faker->randomFloat(2, 10000, $oldPrice);

        return [
            'type' => 'Carro',
            'brand' => $this->faker->company(),
            'model' => $this->faker->word(),
            'version' => $this->faker->boolean(50) ? $this->faker->word() : null,
            'year_model' => $this->faker->numberBetween(2010, 2024),
            'year_build' => $this->faker->numberBetween(2005, 2024),
            'doors' => $this->faker->numberBetween(2, 5),
            'board' => $this->faker->bothify('???-####'),
            'chassi' => $this->faker->boolean(50) ? $this->faker->regexify('[A-Z0-9]{17}') : null,
            'transmission' => $this->faker->randomElement(['Automática', 'Manual']),
            'km' => $this->faker->numberBetween(0, 150000),
            'description' => $this->faker->boolean(80) ? $this->faker->realText(200) : null,
            'created' => $created,
            'updated' => $updated,
            'sold' => $this->faker->boolean(10),
            'category' => $this->faker->randomElement(['SUV', 'Sedan', 'Hatch', 'Pickup']),
            'url_car' => $this->faker->url(),
            'price' => $price,
            'old_price' => $this->faker->boolean(30) ? $oldPrice : null,
            'color' => $this->faker->safeColorName(),
            'fuel' => $this->faker->randomElement(['Gasolina', 'Álcool', 'Diesel', 'Flex', 'Elétrico']),
        ];
    }
}
