<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Encomenda Criada</title>
    <style>
        /* Define your CSS styles here */
    </style>
</head>
<body>
    <h1>Informação de nova encomenda</h1>
    <p>Olá, {{$encomenda->clientes->user->name }}</p>
    <p>Esta é uma notificação de que a sua encomenda está a ser processada.</p>
    <p>Aqui estão os detalhes da encomenda:</p>
    <ul>
        <li>ID da Encomenda: {{ $encomenda->id }}</li>
        <li>Status: {{ $encomenda->status }}</li>
        <li>Preço Total: {{ $encomenda->total_price }} €</li>
        <li>Data de Criação: {{ $encomenda->created_at }}</li>
    </ul>
    <p>Obrigado por comprar conosco!</p>
</body>
</html>
