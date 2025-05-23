<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: admin.php"); // Redireciona se já estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body id="body">
    <div class="conteiner">  
        <div class="content first-content">
            <div class="first-colun">
                <h2 class="title title-primary">Welcome Back!</h2>
                <p class="description description-primary">To keep connected with us</p>
                <p class="description description-primary">Please login with your personal info</p>
                <button id="signin" class="btn btn-primary">Sign in</button>
            </div>
            <div class="second-colun">
                <h2 class="title title-second">create account</h2>
                
                <form class="form" method="POST" action="processa_cadastro.php">
                    <label class="label-input" for="">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="cnome" placeholder=" Nome" required>
                    </label>

                    <label class="label-input" for="">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="cemail" placeholder=" Digite email" required>
                    </label>

                    <label class="label-input" for="">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="ctelefone" placeholder=" Digite telefone">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fa-solid fa-lock icones"></i>
                        <input type="password" name="csenha" placeholder=" Digite sua senha" required>
                    </label>

                    <label class="label-input" for="">
                        <i class="fa-solid fa-lock icones"></i>
                        <input type="password" name="confirmar_senha" placeholder=" Confirme senha" required>
                    </label>

                    <button type="submit" class="btn btn-second">Sign up</button>
                </form>
            </div>
        </div>
        
        <div class="content second-content">
            <div class="first-colun">
                <h2 class="title title-primary">Hello, friend!</h2>
                <p class="description description-primary">Enter you personal details</p>
                <p class="description description-primary">And start journey with us</p>
                <button id="signup" class="btn btn-primary">Sign up</button>
            </div>
            <div class="second-colun">
                <h2 class="title title-second">Bem vindo administrador!</h2>
                <div class="social midia">
                    <ul class="list-social-media">
                        <a class="link-social-midia" href="#">
                            <li class="item-social-media">
                                <i class="fa-brands fa-facebook"></i>
                            </li>
                        </a>
                        <a class="link-social-midia" href="#">
                            <li class="item-social-media">
                                <i class="fa-brands fa-instagram"></i>
                            </li>
                        </a>
                        <a class="link-social-midia" href="#">
                            <li class="item-social-media">
                                <i class="fa-brands fa-whatsapp"></i>
                            </li>
                        </a>
                    </ul>
                </div>
                
                <p class="description description-second">Redes Sociais</p>
                
                <?php if (isset($_SESSION['mensagem_erro'])): ?>
                    <p style="color:red; text-align: center; margin-bottom: 15px;">
                        <?php echo $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                    </p>
                <?php endif; ?>
                
                <form class="form" method="POST" action="processa_login.php">
                    <label class="label-input" for="">
                        <i class="fa-regular fa-envelope icones"></i>
                        <input type="text" id="nome" name="nome" placeholder=" Usuário" required>
                    </label>

                    <label class="label-input" for="">
                        <i class="fa-solid fa-lock icones"></i>
                        <input type="password" id="senha" name="senha" placeholder=" Senha" required>
                    </label>
                    
                    <a class="password" href="redefinir_senha.php">Esqueceu sua senha</a>
                    <button type="submit" class="btn btn-second">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>