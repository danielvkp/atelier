<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Testimonial;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TestimonialFactory extends Factory
{

  protected $model = Testimonial::class;
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */


  public function definition(): array {
      return [
        'nombre' => fake()->name(),
        'cargo' => fake()->name(),
        'rating' => rand(1, 5),
        'descripcion' => fake()->paragraph()
      ];
  }

}
