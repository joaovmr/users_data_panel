<template>
    <th
        @click="sortColumn(columnKey)"
        :style="{ cursor: sortable ? 'pointer' : 'default' }"
        class="table-header"
    >
        <span 
            ref="subscriptionInfo"
            :data-toggle="tooltip ? 'tooltip' : ''"
            data-placement="left"
            :title="tooltip"
        >
            {{ label }}
            <i
                v-if="sortColumnKey === columnKey && sortable === true"
                :class="sortOrder === 'asc' ? 'arrow-up' : 'arrow-down'"
            ></i>
        </span>
    </th>
</template>

<script>
export default {
    props: {
        columnKey: String,
        label: String,
        sortColumnKey: String,
        sortOrder: String,
        sortable: Boolean,
        tooltip: String,
    },
    methods: {
        sortColumn(columnKey) {
            if (this.sortable) {
                this.$emit("sort", columnKey);
            }
        },
    },
};
</script>
