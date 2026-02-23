<h1>Relatório de Ocorrências</h1>

<table border="1" width="100%">
    <tr>
        <th>Aluno</th>
        <th>Sala</th>
        <th>Descrição</th>
        <th>Data</th>
    </tr>

    @foreach ($ocorrencias as $o)
        <tr>
            <td>{{ $o->aluno->nome }}</td>
            <td>{{ $o->aluno->sala->nome }}</td>
            <td>{{ $o->descricao }}</td>
            <td>{{ $o->data }}</td>
        </tr>
    @endforeach
</table>
