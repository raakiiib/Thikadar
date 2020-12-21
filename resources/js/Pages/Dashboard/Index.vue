<template>
    <div>
        <div>
            <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
            
            <div class="mb-8 flex grid grid-cols-3 gap-3 ">

                <inertia-link class="bg-indigo-900 text-indigo-300 flex items-center justify-between md:justify-center" :href="route('suppliers')">
                    <div class="thumbnail ">
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="caption">
                            <h1>ADD NEW PURCHASE</h1>
                        </div>
                    </div>
                </inertia-link>

                <inertia-link class="bg-purple-900 text-indigo-300 flex items-center justify-between md:justify-center" :href="route('suppliers')">
                    <div class="thumbnail ">
                        <div class="caption">
                            <h1>PAY SUPPLIER</h1>
                        </div>
                    </div>
                </inertia-link>

                <inertia-link class="bg-indigo-900 text-indigo-300 flex items-center justify-between md:justify-center h-64" :href="route('suppliers')">
                    <div class="thumbnail ">
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="caption">
                            <h1>PAY STAFFS</h1>
                        </div>
                    </div>
                </inertia-link>
                

            </div>
            <p class="leading-normal">👆 These links are intended to be broken to illustrate how error handling works with Inertia.js.</p>
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
