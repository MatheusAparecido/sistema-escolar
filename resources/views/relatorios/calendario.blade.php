<table border="1" width="100%">
    <thead>
        <tr>
            <th>Aluno</th>
            @foreach($dias as $dia)
                <th>{{ $dia }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($alunos as $aluno)
        <tr>

            <td>{{ $aluno->nome }}</td>

            @foreach($dias as $dia)

                @php
                $registro = $presencas[$aluno->id]
                    ->firstWhere('data', now()->setDay($dia)->format('Y-m-d')) ?? null;
                @endphp

                <td>
                    @if($registro)
                        {{ $registro->presente ? 'C' : 'F' }}
                    @else
                        -
                    @endif
                </td>

            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>