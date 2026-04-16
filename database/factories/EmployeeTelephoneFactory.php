<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeTelephone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeTelephone>
 */
class EmployeeTelephoneFactory extends Factory
{
    /**
     * Summary of model: Modelo EmpleadoTelefono que asociado a la Factory 'EmpleadoTelefonoFactory'.
     * @var
     */
    protected $model = EmployeeTelephone::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            /** Aqui le decimos que utilice el Factory de Employee para rellenar el ID */
            'employee_dni' => Employee::factory(),
            /** Le asignamos el numero de telefono (unico) con 9 digitos aleatorios */
            'telephone' => $this->faker->unique()->numerify('+34#########'),
        ];
    }
}
