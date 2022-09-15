<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head,Link,useForm } from '@inertiajs/inertia-vue3';
    
    const props = defineProps({
      users: {
        type: Object,
        default: () => ({}),
      },
      can: {
        type: Object,
        default: () => ({}),
      },
    });
    const form = useForm();
    function destroy(id) {
        if (confirm("Are you sure you want to Delete")) {
            form.delete(route('user.destroy', id));
        }
    }
    
    </script>
    
    <template>
        <Head title="Users" />
    
        <BreezeAuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                    <div class="flex space-x-2 items-center" v-if="can.create">
                        <a :href="route('user.create')" class="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center"><span class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span> Create User</a>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Name</th>
                                    <th scope="col" class="py-3 px-6">Email</th>
                                    <th v-if="can.edit || can.delete" scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td data-label="Name" class="py-4 px-6">
                                        {{ user.name }}
                                    </td>
                                    <td data-label="Email" class="py-4 px-6">
                                        {{ user.email }}
                                    </td>
                                    <td
                                        v-if="can.edit || can.delete"
                                        class="py-4 px-6"
                                    >
                                        <div type="justify-start lg:justify-end" no-wrap>
                                            <Link tabIndex="1" className="px-4 py-2 text-sm text-white bg-blue-500 rounded" :href="route('user.edit', user.id)">
                                                Edit
                                            </Link>
                                            <BreezeButton  @click="destroy(user.id)" class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer" v-if="can.delete">
                                                Delete
                                            </BreezeButton>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </BreezeAuthenticatedLayout>
    </template>