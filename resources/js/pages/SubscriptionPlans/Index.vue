<script setup>
import AppLayout1 from '@/layouts/AppLayout1.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ plans: Object })
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
                                <a href="javascript:;" class="me-2"><i class="bx bx-home-alt"></i></a> Plan List
                            </h6>
                            <button class="btn btn-primary btn-sm">Add Plan</button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">

                                    </div>
                                    <div class="col-sm-12 col-md-6">

                                    </div>
                                </div>
                                <div class="row">
                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
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
                                                    <span
                                                        class="badge bg-{{ plan.status === 'active' ? 'success' : 'danger' }}">
                                                        {{ plan.status }}
                                                    </span>
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
                        </div>


                        <div class="mt-4">
                            <Link v-for="link in plans.links" :key="link.label" :href="link.url" v-html="link.label"
                                class="px-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout1>
</template>
