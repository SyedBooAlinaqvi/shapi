from django.contrib import admin
from django.urls import path
from . import views


urlpatterns = [
    path('signup', views.users, name='Signup'),
    # path('social_links', views.social_links, name='Social_Links'),
]