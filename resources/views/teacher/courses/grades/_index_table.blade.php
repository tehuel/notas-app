<x-table>
    <x-slot:headers>
        <tr>
            @foreach ($headers as $header)
                <th scope="col">
                    @if (isset($header['url']))
                        <a href="{{ $header['url'] }}">
                            {{ $header['label'] }}
                        </a>
                    @else
                        {{ $header['label'] }}
                    @endif
                </th>
            @endforeach
        </tr>
    </x-slot:headers>

    <x-slot:rows>
        @foreach ($rows as $row)
            <tr>
                @foreach ($row as $key => $value)
                    <td class="align-middle">
                        @if($key === 'student')
                            <a href="{{ route('teacher.courses.students.show', [ 'course' => $course, 'student' => $value ]) }}">
                                {{ $value->name }}
                            </a>
                        @else
                            <x-grade-label :grade="$value" />                                        
                            
                            @php
                                $assessment = $individualAssessments->firstWhere('id', $key);
                                $gradeable = $row['student'];
                            @endphp
                            
                            @if($assessment && $gradeable)
                                @include('teacher.courses.grades._grade_actions', [
                                    'course' => $course,
                                    'assessment' => $assessment,
                                    'gradeable' => $gradeable,
                                ])
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </x-slot:rows>
</x-table>
