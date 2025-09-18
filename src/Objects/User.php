<?php
declare(strict_types=1);

namespace App\Objects;

use App\Enums\Role;

final class User
{
    public function __construct(
        public int $id,
        public string $fullname,
        public string $email,
        public Role $role,
        public ?\DateTimeImmutable $createdAt = null,
    ) {}

    /** Build from a DB row */
    public static function fromArray(array $row): self
    {
        return new self(
            id:        (int)$row['id'],
            fullname:  (string)$row['fullname'],
            email:     (string)$row['email'],
            role:      Role::from((int)$row['role_id']),
            createdAt: isset($row['created_at']) ? new \DateTimeImmutable($row['created_at']) : null,
        );
    }

}
