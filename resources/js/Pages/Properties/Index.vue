<template>
    <div class="container">
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span class="card-header-title">Фильтр поиска недвижимости</span>
            </div>
            <el-form :inline="true" @submit.native.prevent="search" class="search-form">
                <el-row :gutter="20">
                    <el-col :span="6">
                        <el-form-item>
                            <el-input
                                v-model="filters.title"
                                placeholder="Название"
                                prefix-icon="el-icon-search"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="6">
                        <el-form-item>
                            <el-checkbox v-model="filters.has_photo">Есть фото</el-checkbox>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item>
                            <el-checkbox-group v-model="filters.rooms">
                                <el-checkbox :label="1">1 комната</el-checkbox>
                                <el-checkbox :label="2">2 комнаты</el-checkbox>
                                <el-checkbox :label="3">3 комнаты</el-checkbox>
                                <el-checkbox :label="4">4 комнаты</el-checkbox>
                                <el-checkbox :label="5">5 комнат</el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item>
                            <label class="slider-label">Площадь от (м²):</label>
                            <el-slider v-model="filters.area_min" :max="300" :min="0" :step="10" show-stops></el-slider>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item>
                            <label class="slider-label">Площадь до (м²):</label>
                            <el-slider v-model="filters.area_max" :max="300" :min="0" :step="10" show-stops></el-slider>
                        </el-form-item>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item class="form-actions">
                            <el-button type="primary" @click="search">Поиск</el-button>
                            <el-button @click="resetFilters">Сбросить</el-button>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
        </el-card>
        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <span class="card-header-title">Список недвижимости</span>
            </div>
            <el-table :data="properties.data" stripe style="width: 100%">
                <el-table-column prop="title" label="Название"></el-table-column>
                <el-table-column prop="image" label="Картинка">
                    <template #default="scope">
                        <img :src="scope.row.image" alt="" v-if="scope.row.image" style="width: 50px; height: auto;">
                    </template>
                </el-table-column>
                <el-table-column prop="rooms" label="Кол-во комнат"></el-table-column>
                <el-table-column prop="floor" label="Этаж"></el-table-column>
                <el-table-column prop="area" label="Площадь"></el-table-column>
                <el-table-column prop="description" label="Описание"></el-table-column>
            </el-table>
            <div class="pagination-container">
                <el-pagination
                    @current-change="fetchData"
                    :current-page="properties.current_page"
                    :page-size="properties.per_page"
                    layout="total, prev, pager, next"
                    :total="properties.total">
                </el-pagination>
            </div>
        </el-card>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { ref, watch, onMounted } from 'vue';

export default {
    props: {
        properties: Object,
        filters: Object,
    },
    setup(props) {
        const filters = ref({
            title: props.filters.title || '',
            has_photo: props.filters.has_photo || false,
            rooms: props.filters.rooms || [],
            area_min: props.filters.area_min || 0,
            area_max: props.filters.area_max || 300,
        });

        const properties = ref(props.properties);

        const fetchData = (page = 1) => {

            Inertia.get('/', { ...filters.value, page }, {
                preserveState: true,
                onSuccess: (page) => {
                    properties.value = page.props.properties;
                },
            });
        };

        const search = () => {
            fetchData();
        };
        const resetFilters = () => {
            filters.value = {
                title: '',
                has_photo: false,
                rooms: [],
                area_min: 0,
                area_max: 300,
            };
            fetchData();
        };

        watch(() => props.properties, (newProperties) => {
            properties.value = newProperties;
        });

        onMounted(() => {
            properties.value = props.properties;
        });

        return {
            filters,
            properties,
            fetchData,
            search,
            resetFilters
        };
    },
};
</script>

<style scoped>
.container {
    max-width: 1200px;
    margin: 20px auto;
}

.search-form {
    margin-bottom: 20px;
}

.box-card {
    margin-bottom: 20px;
}

.card-header-title {
    font-size: 18px;
    font-weight: bold;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
</style>
