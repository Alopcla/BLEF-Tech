<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 *
 * EmployeeFactory es una clase en la cual definiremos como se deben generar los datos
 * de prueba para un modelo especifico. Su principal cometido es crear instancias de modelos
 * con datos ficticios pero realistas, siguiente una estructura predefinida.
 */
class EmployeeFactory extends Factory
{
    /**
     * Summary of model: Modelo Employee asociado a la Factory 'EmployeeFactory'.
     * @var
     */
    protected $model = Employee::class;

    /**
     * Define el estado por defecto del modelo.
     * Aqui introduciremos los tipos de datos que se introduciran
     * en la base de datos.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** Mediante la libreria Faker, se podra generar nombres, correos y fechas
         * aleatorias que parecen reales. Para ello debemos fijarnos en Migration
         * y ver que campos estan definidos, menos id() y timestamps(), que Laravel
         * lo generara solo automaticamente.
         */
        return [
            /** Las almohadillas '#' indican numeros aleatorios y la interrogacion '?'
             * indica una letra.*/
            'DNI' => $this->faker->unique()->bothify('########?'),
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'birth_date' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'province' => $this->faker->state()
        ];
    }
}
