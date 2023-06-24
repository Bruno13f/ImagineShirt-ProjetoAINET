<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Encomenda {{$cancelada ? 'cancelada' : ''}}{{$confirmada ? 'a ser processada' : ''}}{{$fechada ? 'enviada' : ''}}</title>
</head>
<body>
    <h1>Informação da sua encomenda</h1>
    <p>Olá, {{$encomenda->clientes->user->name }}</p>
    <p>Esta é uma notificação de que a sua encomenda foi {{$cancelada ? 'cancelada' : ''}}{{$confirmada ? 'confirmada' : ''}}{{$fechada ? 'enviada' : ''}}.</p>
    <p>Aqui estão os detalhes da encomenda:</p>
    <ul>
        <li>ID da Encomenda: {{ $encomenda->id }}</li>
        <li>Status: {{$cancelada ? 'Cancelada' : ''}}{{$confirmada ? 'Pendente' : ''}}{{$fechada ? 'Fechada' : ''}}</li>
        <li>Preço Total: {{ $encomenda->total_price }} €</li>
        <li>Data de Criação: {{ $encomenda->created_at }}</li>
    </ul>
    <p>Boa continuação!</p>
</body>
</html>