<template>
    <div>
        <div>
            <h1 class="mb-8 font-bold text-3xl">সেটিংস</h1>
            
            <div class="mb-8 flex grid grid-cols-3 gap-3 ">


                <inertia-link class="w-full sm:w-auto flex-none bg-gray-700 text-gray-400 hover:text-gray-900 font-mono leading-6 py-3 sm:px-6 border border-gray-200 rounded-xl flex items-center justify-center space-x-2 sm:space-x-4 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-300 focus:outline-none transition-colors duration-200" :href="route('suppliers')">
                    <div class="thumbnail ">
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="caption">
                            <h1>ADD NEW PURCHASE</h1>
                        </div>
                    </div>
                </inertia-link>


                <a class="w-full sm:w-auto flex-none bg-gray-900 hover:bg-gray-700 text-white text-lg leading-6 font-semibold py-3 px-6 border border-transparent rounded-xl focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-900 focus:outline-none transition-colors duration-200" href="/docs">সাপ্লায়ার</a>

                <button type="button" class="w-full sm:w-auto flex-none bg-blue-50 text-gray-400 hover:text-gray-900 font-mono leading-6 py-3 sm:px-6 border border-gray-200 rounded-xl flex items-center justify-center space-x-2 sm:space-x-4 focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-300 focus:outline-none transition-colors duration-200">
                    <span class="text-gray-900">পাওনাদার</span>
                </button>

            
                <a class="w-full sm:w-auto flex-none bg-gray-900 hover:bg-gray-700 text-white text-lg leading-6 font-semibold py-3 px-6 border border-transparent rounded-xl focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-900 focus:outline-none transition-colors duration-200" href="/docs">সাপ্লায়ার</a>
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
