import { createRouter, createWebHistory } from 'vue-router';
import AboutView from "../Pages/AboutView.vue";
import HomeView from "../Pages/HomeView.vue";
import AddMovieView from "../Pages/AddMovieView.vue";
import MoviesView from "../Pages/MoviesView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            component: HomeView
        },
        {
            path: '/about',
            component: AboutView
        },
        {
            path: '/movies/create',   // New route
            component: AddMovieView
        },
        {
            path: '/movies', // displays the list of movies
            component: MoviesView
        }
    ]
})

export default router;
