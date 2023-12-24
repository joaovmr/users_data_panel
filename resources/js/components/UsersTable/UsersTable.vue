<template>
    <div class="d-flex justify-content-between align-content-center m-4 mt-5">
        <div class="container-fluid">
            <h1>Users Data - Admin Panel</h1>
            <div class="search-container mt-3">
                <div class="input-group d-flex align-items-center gap-md-3">
                    <div class="col-6 d-flex align-items-center gap-md-3">
                        <label class="mr-2" for="search">Search:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="search"
                            v-model="searchTerm"
                            @input="performSearch"
                        />
                    </div>

                    <div class="input-group-append">
                        <button
                            class="btn btn-secondary"
                            @click="toggleCreditCardVisibility"
                        >
                            {{ hideCreditCard ? "Show" : "Hide" }} Credit Card
                        </button>
                    </div>
                </div>
            </div>

            <table class="table table-striped users-table mt-4">
                <thead>
                    <tr>
                        <TableHeader
                            v-for="column in tableColumns"
                            :key="column.key"
                            :columnKey="column.key"
                            :label="column.label"
                            :sortColumnKey="sortColumnKey"
                            :sortOrder="sortOrder"
                            :sortable="column.sortable ?? true"
                            :tooltip="column.tooltip"
                            @sort="sortColumn"
                        />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in paginatedUsers" :key="user.id">
                        <td>
                            <img
                                width="40"
                                height="40"
                                :src="user.avatar"
                                alt="Avatar"
                            />
                        </td>
                        <td>{{ user.first_name }} {{ user.last_name }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone_number }}</td>
                        <td>{{ user.gender }}</td>
                        <td>{{ formatDate(user.date_of_birth) }}</td>
                        <td>{{ user.social_insurance_number }}</td>
                        <td>{{ user.employment.title }}</td>

                        <td class="address">
                            {{ getShortenedAddress(user.address) }}
                        </td>

                        <td>
                            <span v-if="hideCreditCard">************</span>
                            <span v-else>{{ user.credit_card.cc_number }}</span>
                        </td>
                        <td>
                            <span
                                class="subscription-info"
                                ref="subscriptionInfo"
                                data-toggle="tooltip"
                                data-placement="left"
                                :title="
                                    getSubscriptionTooltip(user.subscription)
                                "
                            >
                                Hover for Details
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination
                class="mt-4"
                :current-page="currentPage"
                :total-pages="totalPages"
                :prev-page="prevPage"
                :next-page="nextPage"
            ></Pagination>
        </div>
    </div>
</template>

<script>
import TableHeader from "./TableHeader.vue";
import Pagination from "./Pagination.vue";

export default {
    props: ["users"],
    data() {
        return {
            currentPage: 1,
            pageSize: 10,
            searchTerm: "",
            sortColumnKey: "name",
            sortOrder: "asc",
            tableColumns: [
                { key: "avatar", label: "Avatar", sortable: false },
                { key: "name", label: "Name" },
                { key: "username", label: "Username" },
                { key: "email", label: "Email" },
                { key: "phone", label: "Phone" },
                { key: "gender", label: "Gender" },
                { key: "birth", label: "Birthdate" },
                {
                    key: "sin",
                    label: "SIN",
                    tooltip: "Social Insurance Number",
                },
                { key: "employmentTitle", label: "Job Title" },
                { key: "address", label: "Address", sortable: false },
                { key: "creditCard", label: "Credit Card", sortable: false },
                {
                    key: "subscription",
                    label: "Subscription Plan",
                    sortable: false,
                },
            ],
            hideCreditCard: true,
        };
    },
    computed: {
        paginatedUsers() {
            const startIndex = (this.currentPage - 1) * this.pageSize;

            let filteredUsers = this.users.filter((user) =>
                this.matchesSearchCriteria(user, this.searchTerm)
            );

            let sortedUsers = filteredUsers.slice().sort((a, b) => {
                const valueA = this.getSortColumnValue(a);
                const valueB = this.getSortColumnValue(b);

                if (this.sortOrder === "asc") {
                    return valueA.localeCompare(valueB);
                } else if (this.sortOrder === "desc") {
                    return valueB.localeCompare(valueA);
                } else {
                    return 0;
                }
            });

            const endIndex = startIndex + this.pageSize;

            return sortedUsers.slice(startIndex, endIndex);
        },
        totalPages() {
            if (this.searchTerm) {
                const filteredUsers = this.users.filter((user) =>
                    this.matchesSearchCriteria(user, this.searchTerm)
                );
                return Math.ceil(filteredUsers.length / this.pageSize);
            } else {
                return Math.ceil(this.users.length / this.pageSize);
            }
        },
    },
    methods: {
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        performSearch() {
            this.currentPage = 1;
        },
        matchesSearchCriteria(user, searchTerm) {
            searchTerm = searchTerm.toLowerCase();
            return (
                user.username.toLowerCase().includes(searchTerm) ||
                user.email.toLowerCase().includes(searchTerm) ||
                (user.first_name + " " + user.last_name)
                    .toLowerCase()
                    .includes(searchTerm) ||
                user.phone_number.toLowerCase().includes(searchTerm) ||
                user.gender.toLowerCase().includes(searchTerm) ||
                user.date_of_birth.toLowerCase().includes(searchTerm) ||
                user.social_insurance_number.toLowerCase().includes(searchTerm)
            );
        },
        sortColumn(columnKey) {
            if (this.sortColumnKey === columnKey) {
                this.sortOrder = this.sortOrder === "asc" ? "desc" : "asc";
            } else {
                this.sortColumnKey = columnKey;
                this.sortOrder = "asc";
            }
        },
        getSortDateValue(dateString) {
            const [year, month, day] = dateString.split("-");
            const timestamp = new Date(`${month}/${day}/${year}`).getTime();
            const formattedDate = new Date(timestamp)
                .toISOString()
                .split("T")[0];
            return formattedDate;
        },

        formatDate(timestamp) {
            const date = new Date(timestamp);
            const day = date.getDate().toString().padStart(2, "0");
            const month = (date.getMonth() + 1).toString().padStart(2, "0");
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        },

        getSortColumnValue(user) {
            switch (this.sortColumnKey) {
                case "name":
                    return (
                        user.first_name +
                        " " +
                        user.last_name
                    ).toLowerCase();
                case "username":
                    return user.username.toLowerCase();
                case "email":
                    return user.email.toLowerCase();
                case "phone":
                    return user.phone_number.toLowerCase();
                case "gender":
                    return user.gender.toLowerCase();
                case "birth":
                    return this.getSortDateValue(user.date_of_birth);
                case "sin":
                    return user.social_insurance_number.toLowerCase();
                case "employmentTitle":
                    return user.employment.title.toLowerCase();
                default:
                    return "";
            }
        },
        toggleCreditCardVisibility() {
            this.hideCreditCard = !this.hideCreditCard;
        },
        getSubscriptionTooltip(subscription) {
            return `Plan: ${subscription.plan}\nStatus:${subscription.status}\nPayment Method: ${subscription.payment_method}\nTerm: ${subscription.term}`;
        },

        getShortenedAddress(address) {
            return `${address.street_address}, ${address.city}, ${address.state}`;
        },
    },
};
</script>
