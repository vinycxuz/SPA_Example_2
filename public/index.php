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
  <header>
    <h3>Name</h3>
    <img src="./images/icon-frontend-mentor.svg" alt="Logo"/>
  </header>
  <div class="menu">
    <div class="menu-text">
      <h1>Nice to meet you!<br>I'm Name</br></h1>
      <p>Based in the Brazil, I'm whatever passionate about building accessible apps that users love.</p>
      <button>CONTACT ME</button>
    </div>
    <div class="menu-image">
      <img src="" alt=""/>
    </div>
  </div>
  <div class="skills-container">
    <div>
      <h2>Skill</h2>
      <p>X Years Experience </p>
    </div>
    <div>
      <h2>Skill</h2>
      <p>X Years Experience </p>
    </div>
    <div>
      <h2>Skill</h2>
      <p>X Years Experience </p>
    </div>
    <div>
      <h2>Skill</h2>
      <p>X Years Experience </p>
    </div>
    <div>
      <h2>Skill</h2>
      <p>X Years Experience </p>
    </div>
    <div>
      <h2>Skill</h2>
      <p>X Years Experience </p>
    </div>
  </div>
  <div class="project-container">
    <div>
      <h1>Projects</h1>
      <button>CONTACT ME</button>
    </div>
    <div class="box-project">
      <div class="project">
        <img src="./images/thumbnail-project-1-small.webp" alt=""/>
        <h3>Project Title</h3>
        <p>Project Description</p>
      </div>
      <div class="project">
        <img src="./images/thumbnail-project-2-small.webp" alt=""/>
        <h3>Project Title</h3>
        <p>Project Description</p>
      </div>
      <div class="project">
        <img src="./images/thumbnail-project-3-small.webp" alt=""/>
        <h3>Project Title</h3>
        <p>Project Description</p>
      </div>
      <div class="project">
        <img src="./images/thumbnail-project-4-small.webp" alt=""/>
        <h3>Project Title</h3>
        <p>Project Description</p>
      </div>
      <div class="project">
        <img src="./images/thumbnail-project-5-small.webp" alt=""/>
        <h3>Project Title</h3>
        <p>Project Description</p>
      </div>
      <div class="project">
        <img src="./images/thumbnail-project-6-small.webp" alt=""/>
        <h3>Project Title</h3>
        <p>Project Description</p>
      </div>  
    </div>
  </div>
  <footer>
  <div class="form_container">
    <div class="form-text">
      <h1>Contact</h1>
      <p>I would love to hear about your project and how I could help. Please fill in the form, nad I'LL get back to your as soon as possible.</p>
    </div>
    <div>  
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-number_container">
          <input class="input-email" type="text" name="email" placeholder="Digite seu email">
        </div>
        <input type="text" class="input-name" name="nome" placeholder="Digite seu nome">
        <button type="submit" value="Submit">Enviar</button>
      </form>
    </div>
    </div>
    <table>
      <tr>
        <th>Email</th>
        <th>Nome</th>
      </tr>
      
    </table>
  </footer>

  <script src="js/script.js"></script>
</body>
</html>
