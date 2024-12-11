<?php
class Ranking implements ActiveRecord {
    private int $idDoLivro;
    private int $avaliaçao;
    private string $emailDoUsuario;

    public function __construct(int $idDoLivro, int $avaliaçao, string $emailDoUsuario) {
        $this->idDoLivro = $idDoLivro;
        $this->avaliaçao = $avaliaçao;
        $this->emailDoUsuario = $emailDoUsuario;
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

    public function setEmailDoUsuario(string $emailDoUsuario): void {
        $this->emailDoUsuario = $emailDoUsuario;
    }

    public function getEmailDoUsuario(): string {
        return $this->emailDoUsuario;
    }

    public function save(): bool {
        $conexao = new MySQL();

        $sqlCheck = "SELECT COUNT(*) as total 
                     FROM ranking 
                     WHERE idDoLivro = {$this->idDoLivro} 
                     AND emailDoUsuario = '{$this->emailDoUsuario}'";
        
        $result = $conexao->consulta($sqlCheck);

        if ($result[0]['total'] > 0) {
            return false; 
        }
       
        $sql = "INSERT INTO ranking (idDoLivro, avaliaçao, emailDoUsuario) 
                VALUES ({$this->idDoLivro}, {$this->avaliaçao}, '{$this->emailDoUsuario}')";
        return $conexao->executa($sql);
    }

    public function delete(): bool {
       
        $conexao = new MySQL();
        $sql = "DELETE FROM ranking 
                WHERE idDoLivro = {$this->idDoLivro} 
                AND emailDoUsuario = '{$this->emailDoUsuario}'";
        return $conexao->executa($sql);
    }

    
    public static function find($id): Ranking {  
        
        $conexao = new MySQL();
        $sql = "SELECT * FROM ranking WHERE idDoLivro = {$id}";
        $result = $conexao->consulta($sql);

        if (empty($result)) {
            return null; 
        }

        $ranking = new Ranking(
            $result[0]['idDoLivro'],
            $result[0]['avaliaçao'],
            $result[0]['emailDoUsuario']
        );
        return $ranking;
    }

    public static function findall(): array {
        
        $conexao = new MySQL();
        $sql = "SELECT idDoLivro, SUM(avaliaçao) AS soma_avaliacoes 
                FROM ranking 
                GROUP BY idDoLivro 
                ORDER BY soma_avaliacoes DESC";
        
        $resultados = $conexao->consulta($sql);

        $rankings = [];
        foreach ($resultados as $resultado) {
            $rankings[] = [
                'idDoLivro' => $resultado['idDoLivro'],
                'soma_avaliacoes' => $resultado['soma_avaliacoes']
            ];
        }
        return $rankings;
    }
}
