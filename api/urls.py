from django.contrib import admin
from django.urls import path
from . import views
from django.contrib.auth import views as auth_views


urlpatterns = [
    path('signup', views.users, name='Signup'),
    path('login', views.login, name='Login'),
    path('meeting', views.meeting, name='Meeting'),
    path('social', views.social, name='SocialLink'),
    path('update_profile', views.update_profile, name='UpdateProfile'),
    path('change_old_password', views.change_old_password, name='ChangeOldPassword'),
    path('forgot_password', views.forgot_password, name='ForgotPassword'),
    path('change_password/<str:token>', views.change_password, name='ChangePassword'),
    path('password_created', views.password_created, name='PasswordCreated'),
    path('done_password', views.done_password, name='PasswordChanged'),
    path('change_email', views.change_email, name='ChangeEmail'),
    path('user_change_email/<str:token>/<str:email>', views.user_change_email, name='UserChangeEmail'),
    
    
    path('admin_login', views.admin_login, name='AdminLogin'),
    path('user_list', views.user_list, name='ListOfUsers'),
    path('user_detail/<str:pk>', views.user_detail, name='DetailOfUsers'),
    path('user_delete/<str:pk>', views.user_delete, name='UserDelete'),
    path('admin_change_pwd', views.admin_change_pwd, name='AdminChangePwd'),
    path('admin_forgot_pwd', views.admin_forgot_pwd, name='AdminForgotPwd'),
    path('admin_forgot_change/<str:email>', views.admin_forgot_change, name='AdminChangePassword'),
    path('admin_logout', views.admin_logout, name='AdminLogout'),
    path('basic', views.basic, name='Basic'),
    path('dashboard', views.dashboard, name='Dashboard'),
    path('myprofile/<str:id>',views.myprofile,name='myprofile'),
    
    
    # Graph
    path('monthly_registration_chart', views.RegisterationChart, name="monthly_registration_chart"),
    
    
    
    # path('graph', views.graph, name="graph"),
]
