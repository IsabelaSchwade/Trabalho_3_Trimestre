<?php
class Ranking implements ActiveRecord {
    private int $idDoLivro;
    private int $avaliaçao;

    public function __construct(int $idDoLivro, int $avaliaçao) {
        $this->idDoLivro = $idDoLivro;
        $this->avaliaçao = $avaliaçao;
    }

    public function setIdDoLivro(int $idDoLivro): void {
        $this->idDoLivro = $idDoLivro;
    }

    public function getIdDoLivro(): int {
        return $this->idDoLivro;
    }

    public function setAvaliaçao(int $avaliaçao): void {
        $this->avaliaçao = $avaliaçao;
    }

    public function getAvaliaçao(): int {
        return $this->avaliaçao;
    }

    public function save(): bool {
        $conexao = new MySQL();
    
        // Verifica se o livro já foi avaliado
        $sqlCheck = "SELECT COUNT(*) as total FROM ranking WHERE idDoLivro = {$this->idDoLivro}";
        $result = $conexao->consulta($sqlCheck);
        
        if ($result[0]['total'] > 0) {
            return false; // Já existe uma avaliação
        }
    
        // Se não existirem avaliações, realiza a inserção
        $sql = "INSERT INTO ranking (idDoLivro, avaliaçao) VALUES ({$this->idDoLivro}, {$this->avaliaçao})";
        return $conexao->executa($sql);
    }

    public function delete(): bool {
        // A avaliação pode ser deletada, mas não é necessário aqui, então vamos deixar vazio
    }

    public static function find($id): Ranking {
        // Método para encontrar uma avaliação se necessário, mas não utilizado no nosso exemplo
    }

    public static function findAll(): array {
        // Método para buscar todas as avaliações, mas não utilizado no nosso exemplo
    }
}
