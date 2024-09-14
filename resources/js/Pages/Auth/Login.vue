<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div class="relative flex items-center justify-center w-full">
            <div class="flex flex-col bg-white px-12 py-8 w-35-pc">

                <img class="w-32 h-auto block mx-auto mb-8" src="/assets/img/logo.png" id="logo" alt="logo">

                <div class="flex flex-col text-2xl font-bold text-center my-4">
                    <span>Bienvenue,</span>
                    <span>Veuillez vous identifiez</span>
                </div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="grow">
                    <div class="my-4 border border-primary rounded-xl px-4 flex items-center gap-2">
                        <!-- <InputLabel for="email" value="Email" /> -->
                        <label for="email"><img class="" src="/assets/icon/email.png" alt=""></label>
                        <TextInput id="email" type="email" class="text-sm w-full grow border-0" v-model="form.email"
                            required placeholder="Email" autofocus autocomplete="username" />
                    </div>
                    <InputError class="mt-2" :message="form.errors.email" />

                    <div class="my-4 border border-primary rounded-xl px-4 flex items-center gap-2">
                        <!-- <InputLabel for="password" value="Mot de passe" /> -->
                        <label for="password"><img class="" src="/assets/icon/lock.png" alt=""></label>
                        <TextInput id="password" class="text-sm w-full grow border-0" v-model="form.password"
                            placeholder="Mot de passe" required :type="showPassword == false ? 'password' : 'text'"
                            autocomplete="current-password" />

                        <img v-if="showPassword == false" @click="showPassword = true" class="cursor-pointer"
                            src="/assets/icon/display.png" alt="display">

                        <img v-else @click="showPassword = false" class="cursor-pointer" src="/assets/icon/hide.png"
                            alt="hide">
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />

                    <PrimaryButton class="w-full bg-primary text-white rounded-xl py-2 mt-4 justify-center"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Connexion
                    </PrimaryButton>

                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="block text-sm text-center mt-4 text-gray-400">
                    Mot de passe
                    oublié?
                    </Link>

                    <div class="text-xs text-center mt-4">
                        ***En accédant à la plateforme, vous acceptez nos <a class="underline" href="">Conditions
                            Générales d'Utilisation</a> et notre <a class="underline" href="">Politique de
                            Confidentialité</a>.
                    </div>
                </form>

                <div class="">
                    <div class="grid grid-cols-6 items-center px-8 mt-6 gap-2">
                        <img src="/assets/img/evd.png" id="evd" alt="evd">
                        <img src="/assets/img/paas_t.png" id="paas_t" alt="paas_t">
                        <img src="/assets/img/sos-savane.png" id="sos-savane" alt="sos-savane">
                        <img src="/assets/img/logo.png" id="logo" alt="logo">
                        <img src="/assets/img/dera.png" id="dera" alt="dera">
                        <img src="/assets/img/ile-ecologique.jpg" id="ile-ecologique" alt="ile-ecologique">
                        <img src="/assets/img/pepiniere_d_afrique.jpg" id="pepiniere_d_afrique" alt="pepiniere_d_afrique">
                        <img src="/assets/img/logo.png" id="logo" alt="logo">
                        <img src="/assets/img/logo.png" id="logo" alt="logo">
                        <img src="/assets/img/logo.png" id="logo" alt="logo">
                        <img src="/assets/img/association_tin_ba.png" id="association_tin_ba" alt="association_tin_ba">
                        <img src="/assets/img/logo.png" id="logo" alt="logo">
                    </div>
                    <hr class="my-4 bg-black">
                    <div class="flex items-center gap-4">
                        <div class="w-1/2">
                            <img class="w-28 block mx-auto" src="/assets/img/maison-des-tortues.png" id="logo" alt="">
                        </div>
                        <div class="flex flex-col gap-2 w-1/2 text-xs">
                            <p>Une solution de suivi d'activité du réseau <span class="font-semibold underline">Maison
                                    des tortues</span>
                            </p>
                            <a href="https://maisondesortues.org/" target="_blank">https://maisondesortues.org/</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.h-screen-vh {
    height: 100vh
}

.w-35-pc {
    width: 35%
}
</style>