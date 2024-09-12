<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from './Header.vue';
import Footer from './Footer.vue';
</script>

<template>

    <Head title="Welcome" />

    <Header />

    <main class="lg:px-28 px-12 grow">
        <section class="flex flex-col gap-8 py-8">
            <div class="lg:w-2/3 mx-auto px-8">
                <h1 class="md:text-4xl text-2xl font-semibold text-center">
                    Participons à la préservation des espèces végétales et animales de notre région.
                </h1>
            </div>

            <div class="flex justify-center gap-8">
                <a href="">
                    <button class="rounded-lg text-white border border-primary bg-primary lg:px-8 md:px-4 px-2 py-2">
                        Découvrir nos sites
                    </button>
                </a>
                <a href="">
                    <button class="rounded-lg text-primary border border-primary lg:px-8 md:px-4 px-2 py-2">
                        Découvrir nos espèces
                    </button>
                </a>
            </div>

            <div class="mt-4 rounded-xl h-96 bg-cover bg-center bg-[url('/assets/img/landing1.jpg')]"></div>
        </section>

        <section class="py-8">
            <div class="md:grid md:grid-cols-3 flex flex-col gap-4 text-center">
                <div class="flex flex-col items-center justify-center">
                    <h2 class="lg:text-7xl text-4xl text-primary font-bold">03</h2>
                    <span>Pays</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="lg:text-7xl text-4xl text-primary font-bold">+20</h2>
                    <span>Sites en Afrique de l'Ouest</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="lg:text-7xl text-4xl text-primary font-bold">+180</h2>
                    <span>Espèces enregistrées</span>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="md:w-2/3 mx-auto text-center my-4">
                <h2 class="lg:text-4xl text-2xl  font-bold text-primary mb-2">Contribuez à la protection des
                    espèces.</h2>
                <p>
                    Toute observation peut contribuer à la conservation de la biodiviersité. Nous
                    travaillons pour la
                    protection des espèces en voie d'extinction et à leur retour dans leur environnement
                    naturel.
                </p>
            </div>

            <div class="lg:grid lg:grid-cols-12 flex flex-col py-12 lg:gap-28 gap-10">
                <div
                    class="lg:col-span-6 lg:order-last rounded-xl bg-cover bg-center bg-[url('/assets/img/landing2.jpg')] h-96 lg:h-auto">
                </div>
                <div class="col-span-3 lg:col-start-2">
                    <div class="flex flex-col gap-4">
                        <img class="w-32" src="/assets/img/location.png" alt="location">
                        <span class="text-2xl font-bold mb-2">Enregistrer un site</span>
                        <p>Enregistrer le site de conservation des espèces que vous gérer.</p>
                        <a href="">
                            <button class="rounded-lg text-sm text-primary border border-primary px-4 py-2">
                                Enregistrer un site
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:grid lg:grid-cols-12 flex flex-col py-12 lg:gap-28 gap-10">
                <div
                    class="lg:col-span-6 lg:col-start-2 rounded-xl bg-cover bg-center bg-[url('/assets/img/landing3.jpg')] h-96 lg:h-auto">
                </div>
                <div class="col-span-3">
                    <div class="flex flex-col gap-4">
                        <img class="w-32" src="/assets/img/footprint.png" alt="footprint">
                        <span class="text-2xl font-bold mb-2">Enregistrer un espèce</span>
                        <p>Enregistrer tous les individus des espèces du site de conservation.</p>
                        <a href="">
                            <button class="rounded-lg text-sm text-primary border border-primary px-4 py-2">
                                Enregistrer un espèce
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:grid lg:grid-cols-12 flex flex-col py-12 lg:gap-28 gap-10 ">
                <div
                    class="lg:col-span-6 lg:order-last rounded-xl bg-cover bg-center bg-[url('/assets/img/landing4.jpg')] h-96 lg:h-auto">
                </div>
                <div class="col-span-3 lg:col-start-2">
                    <div class="flex flex-col gap-4">
                        <img class="w-32" src="/assets/img/graph.png" alt="graph">
                        <span class="text-2xl font-bold mb-2">Evaluer votre site</span>
                        <p>Grâce aux différentes données sur votre site évaluer sa richesse faunique et
                            floristique.</p>
                        <a href="">
                            <button class="rounded-lg text-sm text-primary border border-primary px-4 py-2">
                                Evaluer votre site
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <Footer />
</template>
