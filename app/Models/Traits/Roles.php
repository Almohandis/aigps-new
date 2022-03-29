<?php

namespace App\Models\Traits;

trait Roles {
    public function isMoh() {
        return $this->role_id == 1;
    }

    public function isNationalId() {
        return $this->role_id == 2;
    }

    public function isUser() {
        return $this->role_id == 3;
    }

    public function isMoia() {
        return $this->role_id == 4;
    }

    public function isClerk() {
        return $this->role_id == 5;
    }

    public function isHospital() {
        return $this->role_id == 6;
    }

    public function isPresedentAdvisor() {
        return $this->role_id == 7;
    }

    public function isSpokesPerson() {
        return $this->role_id == 8;
    }

    public function isAdmin() {
        return $this->role_id == 9;
    }
}