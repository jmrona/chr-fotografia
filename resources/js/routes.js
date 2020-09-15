import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import About from './pages/About'
import Contact from './pages/Contact'
import Portfolio from './pages/Portfolio'
import Gallery from './pages/Gallery'
import SocialMedia from './components/SocialMedia'

export default [
    {
        path:'/',
        component: Home,
        name: 'home'
    },
    {
        path:'/register',
        component: Register,
        name: 'register'
    },
    {
        path:'/login',
        component: Login,
        name: 'login'
    },
    {
        path:'/about',
        component: About,
        name: 'about'
    },
    {
        path:'/contact',
        component: Contact,
        name: 'contact'
    },
    {
        path:'/portfolio',
        component: Portfolio,
        name: 'portfolio'
    },
    {
        path:'/gallery/:id',
        component: Gallery,
        name: 'gallery'
    },
    {
        path:'/socialmedia',
        component: SocialMedia,
        name: 'socialmedia'
    }
]
