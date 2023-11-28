<template>
    <form method="GET" action="{{ route('fincas.filter') }}">
        <div class="relative mr-6 my-2">
            <input
                type="search"
                class="bg-purple-white shadow rounded border-0 p-3 me-5"
                placeholder="Search by name..."
            />

            <input value="Search" type="submit" class="bg-blue-500 hover:bg-blue-700 m-5 text-white font-bold py-2 px-4 rounded" />
        </div>
    </form>
</template>
