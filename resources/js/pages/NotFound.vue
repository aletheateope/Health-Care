<script setup>


</script>



<template>
    <div class="min-h-screen flex items-center justify-center bg-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 text-center p-8 bg-white rounded-xl shadow-lg">
            <div class="flex justify-center">
                <div class="bg-red-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div>
                <h1 class="text-6xl font-bold text-gray-800">404</h1>
                <h2 class="mt-4 text-2xl font-semibold text-gray-700">Page Not Found</h2>
                <p class="mt-3 text-gray-600">
                    We couldn't find the page you're looking for. It might have been moved or deleted.
                </p>
            </div>
            <div class="mt-8">
                <router-link
                    to="/"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Return to Homepage
                </router-link>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Need help?
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Contact our support team</a>
                </p>
            </div>
        </div>
    </div>
</template>


<style scoped>
/* Custom animations */
.enter-active {
    animation: fadeIn 0.5s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
