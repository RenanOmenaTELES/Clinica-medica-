<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_medica"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter os dados do formulário
$nome = $_POST['nome'];
$data_nascimento = $_POST['data_nascimento'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$sexo = $_POST['sexo'];

// Verificar se a data de nascimento é válida e maior de idade
$idade = date_diff(date_create($data_nascimento), date_create('today'))->y;
if ($idade < 18) {
    echo "O paciente deve ser maior de idade.";
    exit;
}

// Preparar e executar a consulta SQL para inserir os dados
$stmt = $conn->prepare("INSERT INTO pacientes (nome, data_nascimento, email, telefone, endereco, sexo) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nome, $data_nascimento, $email, $telefone, $endereco, $sexo);

// Executar a consulta e verificar se foi bem-sucedida
if ($stmt->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar paciente: " . $stmt->error;
}

// Fechar a conexão
$stmt->close();
$conn->close();
?>
