<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Encomenda fechada</title>
</head>
<body>
    <h1>Encomenda fechada</h1>
    <p>Olá, {{$encomenda->clientes->user->name }}</p>
    <p>Esta é uma notificação de que a sua encomenda foi fechada e está dispoível o PDF com os detalhes da mesma.</p>
    <p>Aqui estão os detalhes da encomenda incluindo o PDF com o recibo:</p>
    <ul>
        <li>ID da Encomenda: {{ $encomenda->id }}</li>
        <li>Status: {{ $encomenda->status }}</li>
        <li>Preço Total: {{ $encomenda->total_price }} €</li>
        <li>Data de Criação: {{ $encomenda->created_at }}</li>
    </ul>

    <p>Obrigado por comprar conosco!</p>
</body>
</html>
