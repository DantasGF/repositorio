<?php

require_once('src/util/Conexao.php');
require_once('src/model/Objeto.php');
require_once('src/util/Upload.php');

class ObjetoDAO
{
    private $conexao;

    public function __construct()
    {
        $con = new Conexao();
        $this->conexao = $con->obterConexao();
    }

    public function inserir(Objeto $objeto)
    {
        $query = "INSERT INTO objetos (titulo, descricao, id_usuario, data_postagem, 
            assunto, formato, linguagem, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($query);

        $upload = new Upload();
        $dados = $upload->enviarArquivo();

        $objeto->setFormato($dados['formato']);
        $objeto->setUrl($dados['url']);

        $resposta = $stmt->execute(array($objeto->getTitulo(), $objeto->getDescricao(), 
                $objeto->getIdUsuario(), $objeto->getDataPostagem(), $objeto->getAssunto(), 
                $objeto->getFormato(), $objeto->getLinguagem(), $objeto->getUrl()));
        return $resposta;
    }

    public function listarTodos()
    {
        $query = "SELECT * FROM objetos";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        $resposta = $stmt->fetchAll();

        return $resposta; 
    }

    public function listarPorId($id)
    {
        $query = "SELECT * FROM objetos WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(array($id));
        $resposta = $stmt->fetchAll();

        return $resposta; 
    }

    public function editar(Objeto $objeto)
    {
        $query = "UPDATE objetos SET titulo = ?, descricao = ?, assunto = ?, formato = ?,
                linguagem = ?, url = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $resposta = $stmt->execute(array($objeto->getTitulo(), $objeto->getDescricao(),
                $objeto->getAssunto(), $objeto->getFormato(), $objeto->getLinguagem(),
                $objeto->getUrl(), $objeto->getId()));
        return $resposta;
    }

    public function excluir($id)
    {
        /*$query = "UPDATE usuarios SET usuarios WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute(array($id));
        $resposta = $stmt->fetchAll();

        return $resposta;*/
    }
}