<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $post->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="mx-auto max-w-3xl px-4 py-10">


    <a href="{{ route('posts.index') }}"
       class="text-sm font-medium text-indigo-600">

        ← Back to Posts

    </a>


    <article class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">


        <!-- Image -->

        @if($post->image)

            <img src="{{ asset('storage/' . $post->image) }}"
                 alt="{{ $post->title }}"
                 class="max-h-[500px] w-full object-cover">

        @endif


        <div class="p-8">


            <!-- Title -->

            <h1 class="text-3xl font-bold text-gray-900">

                {{ $post->title }}

            </h1>


            <!-- User -->

            <p class="mt-3 text-sm text-gray-500">

                By:

                <span class="font-medium text-gray-800">

                    {{ $post->user->name }}

                </span>

            </p>


            <!-- Description -->

            <p class="mt-6 whitespace-pre-line text-lg leading-8 text-gray-600">

                {{ $post->description }}

            </p>


            <!-- Date -->

            <p class="mt-6 text-sm text-gray-500">

                Created At:

                {{ $post->created_at->format('M d, Y h:i A') }}

            </p>


            <!-- Buttons -->

            <div class="mt-8 flex gap-3">


                <a href="{{ route('posts.edit', $post->id) }}"
                   class="rounded-lg bg-indigo-600 px-5 py-2.5 text-white">

                    Edit Post

                </a>


                <form action="{{ route('posts.destroy', $post->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this post?');">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                            class="rounded-lg bg-red-600 px-5 py-2.5 text-white">

                        Delete

                    </button>

                </form>

            </div>

        </div>

    </article>

</div>

</body>

</html>