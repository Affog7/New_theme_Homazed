
import barba from '@barba/core';
import GLightbox from 'glightbox';

import updateBodyClasses from './updateBodyClasses';

import Home from './pages/home';
import User from './pages/user';
import Post from './pages/post';
import signatureInConsole from './signatureInConsole';

// Components
import Init_Header from './components/header';

import Checkbox_And_Radios_Init from './components/checkbox';
import ScrollTo from './components/scrollTo';
import Maps_Init from './components/maps';
import Tabs_Init from './components/tabs';
import Carrousel_Init from './components/carrousel';
import Jobs_Init from './components/pages/jobs';
import News_Init from './components/pages/news';
import Projects_Init  from './components/pages/project';
import Tags_Init from './components/tags';
import Modals_Init from './components/modal';
import Card_popup_link_Init from './components/card-popup-links';
import Navigation_Init from './components/navigation';
import Tooltip_Init from './components/tooltip';
import CopyBtn_Init from './components/copy-paste';
import MapLaunch from './components/map-functions';

import Cards_Init from './assets/cards';


// import FilePond from "./components/filepond";
import FileUploadInit from "./components/dropzone";

import {  animationEnter, animationLeave } from './animations';
import Profile_Init from "./components/pages/profile";
import Company_Init from "./components/pages/company";

barba.hooks.once((data) => {
	//signatureInConsole();
	Navigation_Init();
    var lightboxDefault = new GLightbox({
        selector: '.glightbox'
    });
    var lightboxSingle = new GLightbox({
        selector: '.glightbox-single'
    });
});

barba.hooks.enter(() => {
	window.scrollTo(0, 0);
	Navigation_Init();
});

if ('scrollRestoration' in history) {
	history.scrollRestoration = 'manual';
}

barba.init({
	debug: true,
	views: [Home, User, Post],
	transitions: [
		{
			name: 'general-transition',
			once: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
			},
			leave: ({ current }) => animationLeave(current.container),
			enter: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
			}
		},

		{
            name: 'home',
            to: {
				namespace: ['home']
			},
            once: ({ next }) => {
 				updateBodyClasses(next);
				animationEnter(next.container);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				Checkbox_And_Radios_Init();
				Modals_Init(next);
				Cards_Init();
News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Tooltip_Init(next);
			},
			leave: ({ current }) => animationLeave(current.container),
            enter: ({ next }) => {
 				updateBodyClasses(next);
                animationEnter(next.container);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				Checkbox_And_Radios_Init();
				Modals_Init(next);
				Cards_Init();
News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Tooltip_Init(next);
			},
        },
		{
            name: 'wall',
            to: {
				namespace: ['wall']
			},
            once: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				Checkbox_And_Radios_Init();
				Modals_Init(next);
				Cards_Init();
News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Maps_Init();
				Tooltip_Init(next);
				FileUploadInit();
			},
			leave: ({ current }) => animationLeave(current.container),
            enter: ({ next }) => {
				updateBodyClasses(next);
                animationEnter(next.container);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				Checkbox_And_Radios_Init();
				Modals_Init(next);
				Cards_Init();
News_Init();
              Profile_Init();
Company_Init();
				CopyBtn_Init();
				Maps_Init();
				Tooltip_Init(next);
				FileUploadInit();
			},
			afterEnter: ({ next }) => {
				ScrollTo(next);
				Jobs_Init(next);
				Projects_Init(next);

				Tags_Init();
 News_Init();
        Profile_Init();
Company_Init();
			}
        },
		{
            name: 'wall--map',
            to: {
				namespace: ['wall--map']
			},
            once: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				Checkbox_And_Radios_Init();
				Modals_Init(next);
				Cards_Init();
News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Tooltip_Init(next);
				MapLaunch(next.container);
			},
			leave: ({ current }) => animationLeave(current.container),
            enter: ({ next }) => {
				updateBodyClasses(next);
                animationEnter(next.container);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				Checkbox_And_Radios_Init();
				Modals_Init(next);
				Cards_Init();
News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Tooltip_Init(next);
				MapLaunch(next.container);
			},
        },
		{
            name: 'user',
            to: {
				namespace: ['user']
			},
            once: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
				Tabs_Init(next);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				MapLaunch(next.container);
				Modals_Init(next);
				CopyBtn_Init();
				Tooltip_Init(next);
				Init_Header();
				Jobs_Init(next);
				Projects_Init(next);
        News_Init();
              Profile_Init();
Company_Init();
				Tags_Init();
				Checkbox_And_Radios_Init();

			},
			leave: ({ current }) => animationLeave(current.container),
            enter: ({ next }) => {
				updateBodyClasses(next);
                animationEnter(next.container);
				Tabs_Init(next);
				Carrousel_Init(next);
				Card_popup_link_Init(next);
				MapLaunch(next.container);
				Modals_Init(next);
				CopyBtn_Init();
				Tooltip_Init(next);
				Init_Header();
				Jobs_Init(next);
				Projects_Init(next);
        News_Init();
              Profile_Init();
Company_Init();
				Tags_Init();
				Checkbox_And_Radios_Init();

			},
        },
		{
            name: 'post',
            to: {
				namespace: ['post']
			},
            once: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
				Tabs_Init(next);
				Carrousel_Init(next);
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				Checkbox_And_Radios_Init();
				News_Init();
              Profile_Init();
Company_Init();
				// Card_popup_link_Init(next);
				MapLaunch(next.container);
				Modals_Init(next);
				CopyBtn_Init();
				Tooltip_Init(next);
				Init_Header();
			},
			leave: ({ current }) => animationLeave(current.container),
            enter: ({ next }) => {
				updateBodyClasses(next);
                animationEnter(next.container);
				Tabs_Init(next);
				Carrousel_Init(next);
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				News_Init();
              Profile_Init();
Company_Init();
				Checkbox_And_Radios_Init();

				// Card_popup_link_Init(next);
				MapLaunch(next.container);
				Modals_Init(next);
				CopyBtn_Init();
				Tooltip_Init(next);
				Init_Header();
			},
        },
		{
            name: 'form',
            to: {
				namespace: ['form']
			},
            once: ({ next }) => {
				updateBodyClasses(next);
				animationEnter(next.container);
				Checkbox_And_Radios_Init();
				ScrollTo(next);
				FileUploadInit();
				Maps_Init();
				News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Tooltip_Init(next);
				Modals_Init(next);
				// FilePond();

			},
			leave: ({ current }) => animationLeave(current.container),
            enter: ({ next }) => {
				updateBodyClasses(next);
                animationEnter(next.container);
				Checkbox_And_Radios_Init();
				FileUploadInit();
				Maps_Init();
				News_Init();
              Profile_Init();
Company_Init();
				Jobs_Init(next);
				Projects_Init(next);
				Tags_Init();
				CopyBtn_Init();
				Tooltip_Init(next);
				Modals_Init(next);
				// FilePond();

			},
            after: ({ next }) => {
				ScrollTo(next);
			},
        }
	]
});

