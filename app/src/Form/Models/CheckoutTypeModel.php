<?php

namespace App\Form\Models;

use Symfony\Component\Validator\Constraints as Assert;

class CheckoutTypeModel
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $surname;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'Некорректный формат e-mail адреса'
    )]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 9,
        minMessage: 'Номер телефона имеет некорректный формат'
    )]
    public string $phone;

    #[Assert\NotBlank]
    public string $address;

    #[Assert\NotBlank]
    public string $orderComment;

    #[Assert\NotBlank]
    #[Assert\Length(
        min       : 6,
        max       : 6,
        minMessage: 'Почтовый индекс не может быть меньше 6 символов',
        maxMessage: 'Почтовый индекс не может быть больше 6 символов'
    )]
    public string $zip;
}