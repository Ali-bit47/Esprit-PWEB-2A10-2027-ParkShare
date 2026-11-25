<?php


class UserModel
{
    
    
    
    private int $id = 0;
    private string $nom = '';
    private string $prenom = '';
    private string $username = '';
    private string $email = '';
    private string $telephone = '';
    private string $password = '';
    private string $role = 'client';
    private string $statut = 'actif';
    private int $failedAttempts = 0;
    private ?string $lockedUntil = null;
    private ?string $lastLogin = null;
    private string $createdAt = '';

    public function __construct()
    {
    }

    
    
    
    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getTelephone(): string { return $this->telephone; }
    public function getPassword(): string { return $this->password; }
    public function getRole(): string { return $this->role; }
    public function getStatut(): string { return $this->statut; }
    public function getFailedAttempts(): int { return $this->failedAttempts; }
    public function getLockedUntil(): ?string { return $this->lockedUntil; }
    public function getLastLogin(): ?string { return $this->lastLogin; }
    public function getCreatedAt(): string { return $this->createdAt; }

    
    
    
    public function setId(int $id): void { $this->id = $id; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setTelephone(string $telephone): void { $this->telephone = $telephone; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setRole(string $role): void { $this->role = $role; }
    public function setStatut(string $statut): void { $this->statut = $statut; }
    public function setFailedAttempts(int $n): void { $this->failedAttempts = $n; }
    public function setLockedUntil(?string $date): void { $this->lockedUntil = $date; }
    public function setLastLogin(?string $date): void { $this->lastLogin = $date; }
    public function setCreatedAt(string $createdAt): void { $this->createdAt = $createdAt; }

    
    
    
    public static function fromArray(array $row): self
    {
        $user = new self();
        $user->setId((int) ($row['id'] ?? 0));
        $user->setNom((string) ($row['nom'] ?? ''));
        $user->setPrenom((string) ($row['prenom'] ?? ''));
        $user->setUsername((string) ($row['username'] ?? ''));
        $user->setEmail((string) ($row['email'] ?? ''));
        $user->setTelephone((string) ($row['telephone'] ?? ''));
        $user->setPassword((string) ($row['password'] ?? ''));
        $user->setRole((string) ($row['role'] ?? 'client'));
        $user->setStatut((string) ($row['statut'] ?? 'actif'));
        $user->setFailedAttempts((int) ($row['failed_attempts'] ?? 0));
        $user->setLockedUntil($row['locked_until'] ?? null);
        $user->setLastLogin($row['last_login'] ?? null);
        $user->setCreatedAt((string) ($row['created_at'] ?? ''));
        return $user;
    }
}
