<template>
    <div class="pagination mt-3">
        <button
            @click="prevPage"
            type="button"
            class="btn btn-secondary"
            :disabled="currentPage === 1"
        >
            Previous
        </button>
        <div class="page-info-container">
            <span class="page-info">{{ currentPage }} / {{ totalPages }}</span>
        </div>
        <button
            @click="nextPage"
            type="button"
            class="btn btn-secondary"
            :disabled="currentPage === totalPages"
        >
            Next
        </button>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: Number,
        totalPages: Number,
        prevPage: Function,
        nextPage: Function,
    },
};
</script>
