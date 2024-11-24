<?php

class Livro implements ActiveRecord{

    private int $idLivro;
    
    public function __construct(private string $nomeLivro,private string $imagemLivro){
    }

    public function setIdLivro(int $idLivro):void{
        $this->idLivro = $idLivro;
    }

    public function getIdLivro():int{
        return $this->idLivro;
    }

    public function setNomeLivro(string $nomeLivro):void{
        $this->nomeLivro = $nomeLivro;
    }

    public function getNomeLivro():string{
        return $this->nomeLivro;
    }

    public function setimagemLivro(string $imagemLivro):void{
        $this->imagemLivro = $imagemLivro;
    }

    public function getimagemLivro():string{
        return $this->imagemLivro;
    }


    public function save():bool{
        $conexao = new MySQL();
        if(isset($this->idLivro)){
            $sql = "UPDATE livro SET nomeLivro = '{$this->nomeLivro}' ,imagemLivro = '{$this->imagemLivro}' WHERE idLivro = {$this->idLivro}";
        }else{
            $sql = "INSERT INTO livro (nomeLivro, imagemLivro) VALUES ('{$this->nomeLivro}','{$this->imagemLivro}')";
        }
        return $conexao->executa($sql);
        
    }
    public function delete():bool{
        $conexao = new MySQL();
        $sql = "DELETE FROM livro WHERE idLivro = {$this->idLivro}";
        return $conexao->executa($sql);
    }

    public static function find($idLivro):Livro{
        $conexao = new MySQL();
        $sql = "SELECT * FROM livro WHERE idLivro = {$idLivro}";
        $resultado = $conexao->consulta($sql);
        $f = new livro($resultado[0]['nomeLivro'],$resultado[0]['imagemLivro']);
        $f->setIdLivro($resultado[0]['idLivro']);
        return $f;
    }
    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM livro";
        $resultados = $conexao->consulta($sql);
        $livros = array();
        foreach($resultados as $resultado){
            $f = new livro($resultado['nomeLivro'],$resultado['imagemLivro']);
            $f->setIdLivro($resultado['idLivro']);
            $livros[] = $f;
        }
        return $livros;
    }

    
}