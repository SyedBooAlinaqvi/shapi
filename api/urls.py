from django.contrib import admin
from django.urls import path
from . import views


urlpatterns = [
    path('signup', views.users, name='Signup'),
    path('login', views.login, name='Login'),
    path('meeting', views.meeting, name='Meeting'),
    path('social', views.social, name='SocialLink'),
    
]