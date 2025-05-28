<script setup>
import AppLayout1 from '@/layouts/AppLayout1.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';

const props = defineProps({
    plans: Object,
    filters: Object
});

const search = ref(props.filters.search || '');
const perPage = ref(props.filters.perPage || 10);

const form = useForm({
     name: '',
     price: '',
     duration: '',
     description: '',
     interval:'',
     is_active:''
});

const updateStatus = (plan) => {
    router.put(`/plans/${plan.id}/status`, {
        is_active: plan.is_active
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Optionally show a toast or success message
        },
    });
}

// Watchers
watch([search, perPage], () => {
    router.get(route('subscription-plans.index'), {
        search: search.value,
        perPage: perPage.value,
    }, {
        preserveState: true,
        replace: true,
    });
});
</script>
<template>

    <Head title="Subscription Plan" />
    <AppLayout1>
        <div class="row">
            <div class="col-lg-12">
                <h4 class="mb-3 text-primary text-center font-bold">Subscription Plans</h4>
                <!-- <div class="pull-right"  style="margin-top: 25px;"></div>  -->
            </div>
            <div class="col-12 col-lg-12">
                <div class="card radius-2 border-top border-0 border-2 border-primary">
                    <div class="card-header">
                        <div class="card-title d-flex justify-content-between justify-center align-items-center"
                            style="margin-bottom: 0;">
                            <h6 class="mb-0 text-primary d-flex align-items-center">
                                <a href="javascript:;" class="me-2"><i class="fadeIn animated bx bx-list-ul"></i></a>
                                Plan List
                            </h6>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"><i class="fadeIn animated bx bx-plus-medical"
                                    style="font-size: small;"></i>Add Plan</button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="example_length">
                                            <label>Show
                                                <select v-model="perPage" name="example_length" aria-controls="example"
                                                    class="form-select form-select-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> entries</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div id="example_filter" class="dataTables_filter">
                                            <label>Search:<input v-model="search" type="search"
                                                    class="form-control form-control-sm" placeholder=""
                                                    aria-controls="example"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example" class="table table-striped table-bordered dataTable"
                                            style="width: 100%;" role="grid" aria-describedby="example_info">
                                            <thead>
                                                <tr role="row">
                                                    <th>Sl</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Duration</th>
                                                    <th>Interval</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(plan, index) in plans.data" :key="plan.id">
                                                    <td>{{ index + 1 }}</td>
                                                    <td>{{ plan.name }}</td>
                                                    <td>{{ plan.price }}</td>
                                                    <td>{{ plan.duration }}</td>
                                                    <td>{{ plan.interval }}</td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="flexSwitchCheckChecked" v-model="plan.is_active"
                                                                @change="updateStatus(plan)" :checked="plan.is_active">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <Link :href="`/plans/${plan.id}/edit`" class="text-primary"><i
                                                            class="fadeIn animated bx bx-edit hover:opacity-90"
                                                            style="font-size: larger;"></i></Link>
                                                        <Link :href="`/plans/${plan.id}`" class="text-danger"><i
                                                            class="fadeIn animated bx bx-trash hover:opacity-90"
                                                            style="font-size: larger;"></i></Link>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" role="status" aria-live="polite">
                                            Showing {{ plans.from }} to {{ plans.to }} of {{ plans.total }} entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers">
                                            <ul class="pagination" style="display: flex; gap: 4px;">
                                                <li v-for="link in plans.links" :key="link.label"
                                                    class="paginate_button page-item"
                                                    :class="{ active: link.active, disabled: !link.url }">
                                                    <Link :href="link.url || '#'" v-html="link.label" class="page-link"
                                                        :class="{ 'bg-primary text-white': link.active, 'text-muted': !link.url }" />
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i
                                    class="fadeIn animated bx bx-message-alt-add"></i> Add Subscription Plans</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-body">
                                    <form @submit.prevent="submit" class="row">
                                        <div class="col-12 mb-2">
                                            <Label for="name" class="mb-1">Name</Label>
                                            <Input id="name" type="email"
                                                :class="[form.errors.name ? 'border-danger mb-2' : '']" required
                                                autofocus :tabindex="1" autocomplete="email" v-model="form.name"
                                                placeholder="premium" />
                                            <InputError :message="form.errors.name" />
                                        </div>

                                        <div class="col-12">
                                            <Label for="name" class="mb-1">Price</Label>
                                            <Input id="name" type="number"
                                                :class="[form.errors.name ? 'border-danger mb-1' : '']" required
                                                autofocus :tabindex="1" autocomplete="email" v-model="form.name"
                                                placeholder="premium" />
                                            <InputError :message="form.errors.name" />
                                        </div>

                                        <div class="col-12">
                                            <Label for="name" class="mb-1">Duration</Label>
                                            <Input id="name" type="number"
                                                :class="[form.errors.name ? 'border-danger mb-1' : '']" required
                                                autofocus :tabindex="1" autocomplete="email" v-model="form.name"
                                                placeholder="premium" />
                                            <InputError :message="form.errors.name" />
                                        </div>

                                        <div class="col-12 mb-2">
                                            <Label for="name" class="mb-1">Interval</Label>
                                            <Input id="name" type="email"
                                                :class="[form.errors.name ? 'border-danger mb-2' : '']" required
                                                autofocus :tabindex="1" autocomplete="email" v-model="form.name"
                                                placeholder="premium" />
                                            <InputError :message="form.errors.name" />
                                        </div>

                                    </form>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout1>
</template>
