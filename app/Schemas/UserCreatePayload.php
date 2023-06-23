<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="UserCreatePayload",
 *     required={"name", "email", "password", "celular", "sexo", "data_nascimento"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *     @OA\Property(property="password", type="string", example="secret123"),
 *     @OA\Property(property="celular", type="string", example="(99) 99999-9999"),
 *     @OA\Property(property="sexo", type="string", enum={"Masculino", "Feminino"}),
 *     @OA\Property(property="data_nascimento", type="string", format="date", example="2000-01-01"),
 *     @OA\Property(property="avatar", type="string", nullable=true),
 *     @OA\Property(property="active", type="boolean", default=true)
 * )
 */
class UserCreatePayload
{
}