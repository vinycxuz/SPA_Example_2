<?php
  session_start();
  $host = "localhost";
  $dbname = "YOUR DBNAME";
  $username = "YOUR USERNAME";
  $password = "YOUR PASSWORD";

  try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nome = $_POST['nome'];

    if (!empty($email) && !empty($nome)) {
      try {
        $sql = "CREATE TABLE IF NOT EXISTS corretor (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(80),
                nome VARCHAR(80)
            )";
        $pdo->exec($sql);
    
        $sql = "INSERT INTO corretor (email, nome) VALUES (:email, :nome)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        
        echo "<div class=\"box-message\"><div><p class=\"sucess\">Corretor cadastrado com sucesso!</p></div></div>";
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=true");
        exit();
      } catch(PDOException $e) {
        echo "<div class=\"box-message\"><div><p>Erro ao cadastrar.</p></div></div>";
      }
    } else {
      echo "<div class=\"box-message\"><div><p>Preencha o formulário corretamente.</p></div></div>";
    }
  } elseif (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    try {
        $sql = "DELETE FROM corretor WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $delete_id);
        $stmt->execute();
        echo "<div class=\"box-message\"><div><p class=\"sucess\">Corretor deletado com sucesso!</p></div></div>";
    } catch(PDOException $e) {
        echo "Erro ao deletar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <main>
  <div class="form_container">
    <h2>Cadastro de Corretor</h2>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-number_container">
          <input class="input-email" type="text" name="email" placeholder="Digite seu email">
        </div>
        <input type="text" class="input-name" name="nome" placeholder="Digite seu nome">
        <button type="submit" value="Submit">Enviar</button>
      </form>
    </div>
    <table>
      <tr>
        <th>Email</th>
        <th>Nome</th>
      </tr>
      <?php
        $sql = "SELECT * FROM corretor";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch()) {
          echo "<tr><td>".$row['email']."</td><td>".$row['nome']."</td><td>" . "<a href='index.php?delete_id=".$row['id']."'>Deletar</a></td><td> <a href='edit.php?id=".$row['id']."'>Editar</a></td></tr>";
        }
      ?>
    </table>
  </main>

  <script src="js/script.js"></script>
</body>
</html>