<script setup>
    import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head ,useForm } from '@inertiajs/inertia-vue3';
    import BreezeLabel from '@/Components/InputLabel.vue';
    import BreezeInput from '@/Components/TextInput.vue';
    import axios from 'axios';
    const props = defineProps({
        users: {
            type: Object,
            default: () => ({}),
        },
        can: {
            type: Object,
            default: () => ({}),
        },
    })
    const form = useForm({
        name: '',
        email: '',
        password: '',
        c_password: '',
    });
  
    const userCreate = () => {
        form.post(route('user.store'));
        form.name = '';
        form.email = '';
        form.password = '';
        form.c_password = '';
    };
    </script>
    
    <template>
        <Head title="Users" />
    
        <BreezeAuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5 w-1/2">
                    <div class="flex space-x-2 items-center" v-if="can.create">
                        <a :href="route('user.index')" class="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center"><span class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span>User Lists</a>
                    </div>
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-1/2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <!-- name Input -->
                            <form @submit.prevent="userCreate"  class="mb-3">
                                <BreezeLabel for="title" value="Name" />
                                <BreezeInput type="text" v-model="form.name" class="w-full" placeholder="Enter name"/>
                                <span className="text-red-600" v-if="form.errors.name">
                                    {{ form.errors.name }}
                                </span>
                                <!-- email Input -->
                                <BreezeLabel for="title" value="Email"  class="mt-6"/>
                                <BreezeInput type="email" class="w-full" v-model="form.email" placeholder="Enter email"/>
                                <span className="text-red-600" v-if="form.errors.email">
                                    {{ form.errors.email }}
                                </span>
                                <!-- password Input -->
                                <BreezeLabel for="title" value="Password"  class="mt-6"/>
                                <BreezeInput type="password" v-model="form.password" class="w-full" placeholder="Enter password"/>
                                <span className="text-red-600" v-if="form.errors.password">
                                    {{ form.errors.password }}
                                </span>
                                <!-- Confirm password Input -->
                                <BreezeLabel for="title" value="Confirm Password"  class="mt-6"/>
                                <BreezeInput type="password" v-model="form.c_password" class="w-full " placeholder="Enter confirm password" />
                                <span className="text-red-600" v-if="form.errors.c_password">
                                    {{ form.errors.c_password }}
                                </span>
                                <button type="submit" class="mt-6 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                   Submit
                               </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </BreezeAuthenticatedLayout>
    </template>