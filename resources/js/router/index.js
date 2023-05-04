import { createRouter, createWebHistory } from "vue-router";

import About from '../pages/About.vue'
import Home from "../pages/Home.vue";
import Blog from "../pages/Blog.vue";
import Contact from "../pages/Contact.vue";
import SingleBlog from "../pages/SingleBlog.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";
import CreateCategories from "../pages/categories/CreateCategories.vue";
import CategoriesList from "../pages/categories/CategoriesList.vue";
import EditCategories from "../pages/categories/EditCategories.vue";
import CreatePosts from "../pages/posts/CreatePosts.vue";
import DashboardPostsList from "../pages/posts/DashboardPostsList.vue";
import EditPosts from "../pages/posts/EditPosts.vue";
import Profile from "../pages/userfunctions/Profile.vue";
import EditAccount from "../pages/userfunctions/EditAccount.vue";
import ViewUsers from "../pages/adminfunctions/ViewUsers.vue";
import UserDetails from "../pages/adminfunctions/UserDetails.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/about",
        name: "About",
        component: About,
    },
    {
        path: "/blog",
        name: "Blog",
        component: Blog,
    },
    {
        path: "/contact",
        name: "Contact",
        component: Contact,
    },
    {
        path: "/blog/:slug",
        name: "SingleBlog",
        component: SingleBlog,
        props: true,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: { requiresGuest: true }
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: { requiresGuest: true }
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
        meta: { requiresAuth: true }
    },
    {
        path: "/editaccount",
        name: "EditAccount",
        component: EditAccount,
        meta: { requiresAuth: true }
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    {
        path: "/categories/create",
        name: "CreateCategories",
        component: CreateCategories,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
        path: "/categories",
        name: "CategoriesList",
        component: CategoriesList,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
        path: "/categories/:id/edit",
        name: "EditCategories",
        component: EditCategories,
        meta: { requiresAuth: true, requiresAdmin: true },
        props: true
    },
    {
        path: "/viewusers",
        name: "ViewUsers",
        component: ViewUsers,
        meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
        path: "/userdetails/:id",
        name: "UserDetails",
        component: UserDetails,
        meta: { requiresAuth: true, requiresAdmin: true },
    },

    {
        path: "/posts/create",
        name: "CreatePosts",
        component: CreatePosts,
        meta: { requiresAuth: true },
    },

    {
        path: "/dashboard-posts",
        name: "DashboardPostsList",
        component: DashboardPostsList,
        meta: { requiresAuth: true },
    },

    {
        path: "/posts/:slug/edit",
        name: "EditPosts",
        component: EditPosts,
        meta: { requiresAuth: true },
        props: true
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    const authenticated = localStorage.getItem("authenticated");
    const role = localStorage.getItem("role");

    // If the route requires a guest and the user is authenticated
    if (to.meta.requiresGuest && authenticated) {
        return {
            name: "Dashboard",
        };
    }

    // If the route requires authentication and the user is not authenticated
    else if (to.meta.requiresAuth && !authenticated) {
        return {
            name: "Login",
        };
    }

    // If the route requires an admin and the user is not an admin
    else if (to.meta.requiresAdmin && role !== 'admin') {
        return {
            name: "Home", // Redirect to home or any other route
        };
    }
});


export default router;