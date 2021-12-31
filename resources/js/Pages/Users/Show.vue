<template>
    <app-layout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="mt-10">
            <table class="border-collapse table-fixed w-full text-sm">
                <thead>
                    <tr>
                        <th
                            class="
                                border-b
                                dark:border-gray-600
                                font-medium
                                p-4
                                pl-8
                                pt-0
                                pb-3
                                text-gray-400
                                dark:text-gray-200
                                text-left
                            "
                        >
                            #ID
                        </th>
                        <th
                            class="
                                border-b
                                dark:border-gray-600
                                font-medium
                                p-4
                                pt-0
                                pb-3
                                text-gray-400
                                dark:text-gray-200
                                text-left
                            "
                        >
                            Name
                        </th>
                        <th
                            class="
                                border-b
                                dark:border-gray-600
                                font-medium
                                p-4
                                pr-8
                                pt-0
                                pb-3
                                text-gray-400
                                dark:text-gray-200
                                text-left
                            "
                        >
                            Email
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800">
                    <tr v-for="item in users.data" :key="item.id">
                        <td
                            class="
                                border-b border-gray-100
                                dark:border-gray-700
                                p-4
                                pl-8
                                text-gray-500
                                dark:text-gray-400
                            "
                        >
                           {{ item.id }}
                        </td>
                        <td
                            class="
                                border-b border-gray-100
                                dark:border-gray-700
                                p-4
                                text-gray-500
                                dark:text-gray-400
                            "
                        >
                           {{ item.name }}
                        </td>
                        <td
                            class="
                                border-b border-gray-100
                                dark:border-gray-700
                                p-4
                                pr-8
                                text-gray-500
                                dark:text-gray-400
                            "
                        >
                            {{ item.email }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default defineComponent({
    props: {
        users: Object,
    },

    components: {
        AppLayout,
    },
});
</script>
