<?php
namespace App\DTO;

use App\Entity\User;

class BookLoanDTO
{
    private User $user;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }


}