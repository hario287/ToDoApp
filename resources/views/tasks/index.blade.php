@extends('layouts.app')
   @vite('resources/css/app.css')
   @section('content')
   <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="/tasks" method="post" class="mt-3">
                  @csrf
                  <div class="flex flex-col items-center">
                    <label class="w-full max-w-3xl mx-auto">
                        <input
                            class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md py-4 pl-4 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm"
                            placeholder="ここにタスクを記入" type="text" name="task_name" />
                        @error('task_name')
                        <div class="mt-3">
                            <p class="text-red-500">
                                {{ $message }}
                            </p>
                        </div>
                        @enderror
                    </label>
 
                    <button type="submit" class="mt-8 p-4 bg-slate-800 w-full shadow-lg px-2 py-1 bg-blue-400 text-lg text-white max-w-xs hover:bg-blue-500 hover:shadow-sm hover:translate-y-0.5 transform transition ">
                        追加する
                    </button>
                  </div>
                </form>

                <div class="col mt-20">
                    {{ __('タスクを検索') }}
                    
                        <form action="{{ route('tasks.index') }}" method="GET">
                        <input type="name" name="keyword" value="{{ $keyword }}">
                        <div class="my-2">
                            <input type="submit" value="検索" class="bg-zinc-500/100 px-2 py-1 text-white">
                        </div>
                    </form>
                </div>

                @if ($tasks->isNotEmpty())
                    <div class="mx-auto mt-10">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                                            タスク</th>
                                        <th scope="col" class="relative py-3.5 pl-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($tasks as $item)
                                        <tr>
                                            <td class="px-3 py-4 text-sm text-gray-500">
                                                <div>
                                                    {{ $item->name }}
                                                </div>
                                            </td>
                                            <td class="p-0 text-right text-sm font-medium">
                                                <div class="flex justify-end">
                                                    <div>
                                                        <form action="/tasks/{{ $item->id }}"
                                                            method="post"
                                                            class="pt-3 inline-block text-gray-500 font-medium"
                                                            role="menuitem" tabindex="-1">
                                                            @csrf
                                                            @method('PUT')
                                                            
                                                            <!-- if文 -->
                                                            @if ($item->status == 1)
                                                                <span class="p-5 text-center">完了</span>
                                                            @else
                                                                <span class="p-5 text-center">未完了</span>
                                                            @endif

                                                                <!-- <input type="label" class="py-4 w-20" name="status" value="{{$item->status}}"> -->
                                                            
                                                            <button type="submit"
                                                                class="bg-emerald-500 py-4 w-20 text-white md:hover:bg-emerald-800 transition-colors">
                                                                完了</button>
                                                        </form>
                                                        <a href="/tasks/{{ $item->id }}/edit/"
                                                            class="inline-block text-center py-4 w-20 underline underline-offset-2 text-sky-600">
                                                            編集</a>
                                                    
                                                        <form onsubmit="return deleteTask();"
                                                            action="/tasks/{{ $item->id }}" method="post"
                                                            class="inline-block text-gray-500 font-medium"
                                                            role="menuitem" tabindex="-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="mr-3 py-4 w-20 md:hover:bg-slate-200 transition-colors">削除</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

<script>
    function deleteTask() {
        if (confirm('本当に削除しますか？')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection