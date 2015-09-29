<?php

$validator
    ->field('username')
        ->required()
        ->email()
        ->minLength(10)
    ->field('password')
        ->sameAs('username');

$valdidator
    ->rule($rules->field('username')
            ->filter($filters->required())
            ->filter($filters->minLength(10))