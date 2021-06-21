from django.db import models

# Create your models here.
class Users(models.Model):
    name = models.CharField(max_length=30)
    email = models.EmailField(max_length=50, unique=True)
    password = models.CharField(max_length=200)
    profession = models.CharField(max_length=200)
    phone_no = models.CharField(max_length=30, null=True)
    image = models.ImageField(upload_to='images', null=True)
    
    
class Meetings(models.Model):
    user_id = models.IntegerField()
    link = models.CharField(max_length=255)
    

class Social_links(models.Model):
    user_id = models.IntegerField()
    insta = models.CharField(max_length=255, null=True)
    fb = models.CharField(max_length=255, null=True)
    linkedIn = models.CharField(max_length=255, null=True)
    youtube = models.CharField(max_length=255, null=True)
    