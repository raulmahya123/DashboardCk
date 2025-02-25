<template x-if="selectedMenu">
    <div class="bg-white shadow-lg rounded-lg w-full h-[80vh] flex flex-col space-y-2">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold flex items-center">
                <i data-lucide="bar-chart-2" class="mr-2"></i> Dashboard BI
            </h3>
        </div>
        <iframe :src="selectedMenu" class="w-full h-[68vh] flex-grow rounded-lg" frameborder="0" allowfullscreen></iframe>
    </div>
</template>
