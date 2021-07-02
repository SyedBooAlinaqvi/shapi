from django.db import models
from django.db.models.deletion import CASCADE
from django.contrib.auth.models import AbstractUser
import datetime
# Create your models here.
class Users(models.Model):
    name = models.CharField(max_length=30)
    email = models.EmailField(max_length=50, unique=True)
    password = models.CharField(max_length=200)
    profession = models.CharField(max_length=200)
    phone_no = models.CharField(max_length=30, null=True)
    address = models.CharField(max_length=100, null=True, default='')
    image = models.ImageField(upload_to='images', null=True)
    forget_password_token = models.CharField(max_length=100, null=True, default='')
    created_at = models.DateTimeField(auto_now_add=True)
    
    
class Meetings(models.Model):
    # users = models.ForeignKey(Users, on_delete=models.CASCADE, default=1) 
    user_id = models.IntegerField()
    link = models.CharField(max_length=255)
    

class Social_links(models.Model):
    # users = models.OneToOneField(Users, on_delete=models.CASCADE, default=1)
    user_id = models.IntegerField()
    insta = models.CharField(max_length=255, null=True)
    fb = models.CharField(max_length=255, null=True)
    linkedIn = models.CharField(max_length=255, null=True)
    youtube = models.CharField(max_length=255, null=True)
    