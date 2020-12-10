<template>
    <div>
        <div>
            <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
            <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 underline hover:text-orange-600" href="https://inertiajs.com">Inertia.js</a> works.</p>
            <div class="mb-8 flex">
                <inertia-link class="btn-indigo" href="/500">500 error</inertia-link>
                <inertia-link class="btn-indigo ml-1" href="/404">404 error</inertia-link>
            </div>
            <p class="leading-normal">👆 These links are intended to be broken to illustrate how error handling works with Inertia.js.</p>
        </div>

        <div class="mt-8 flex ">

            <div class="space-4">
                <a href="https://github.com/tailwindlabs/tailwindcss/discussions" class="flex items-start space-x-4">
                    <svg width="50" class="svg-inline--fa fa-arrow-circle-up fa-w-16 mr-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-circle-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M8 256C8 119 119 8 256 8s248 111 248 248-111 248-248 248S8 393 8 256zm143.6 28.9l72.4-75.5V392c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V209.4l72.4 75.5c9.3 9.7 24.8 9.9 34.3.4l10.9-11c9.4-9.4 9.4-24.6 0-33.9L273 107.7c-9.4-9.4-24.6-9.4-33.9 0L106.3 240.4c-9.4 9.4-9.4 24.6 0 33.9l10.9 11c9.6 9.5 25.1 9.3 34.4-.4z"></path></svg>

                    <div class="flex-auto">
                        <h3 class="font-bold text-gray-900">GitHub Discussions</h3>
                        <p>Connect with members of the Tailwind CSS community.</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
    metaInfo: { title: 'Dashboard' },
    layout: Layout,
}
</script>
