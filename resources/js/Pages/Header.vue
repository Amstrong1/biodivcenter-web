<template>
    <header class="lg:px-28 px-12 flex-none">
        <nav class="flex items-center justify-between bg-white py-6">
            <div>
                <a href="/"><img class="md:h-16 h-12" src="/assets/img/logo.png" alt="logo"></a>
            </div>
            <div class="flex lg:gap-8 gap-4 items-center">
                <a href="/guest/sites"
                    :class="{ 'text-primary font-bold border-b-2 border-primary': $page.url === '/guest/sites' }" class="">
                    Sites
                </a>
                <a href="/guest/species"
                    :class="{ 'text-primary font-bold border-b-2 border-primary': $page.url === '/guest/species' }">
                    Espèces
                </a>
                <a href="/dashboard">
                    <button class="rounded-lg text-white border border-primary bg-primary lg:px-8 p-2">
                        Se connecter
                    </button>
                </a>
            </div>
        </nav>
    </header>
</template>