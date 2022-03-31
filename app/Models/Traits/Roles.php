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

    public function isEmployee() {
        return $this->role_id != 3;
    }

    public function getRoleName() {
        return $this->getRoleNames()[$this->role_id - 1];
    }

    public function scopeEmployees($query) {
        return $query->where('role_id', '!=', '3');
    }

    public static function getRoleNames() {
        return [
            'Ministry of health Clerk',
            'National Id Entry Clerk',
            'System User',
            'Ministry of Internal Affairs Clerk',
            'Campaign Clerk',
            'Hospital Clerk',
            'Preseident Advisor Clerk',
            'Spokes Person Clerk',
            'System Admin Clerk'
        ];
    }
}