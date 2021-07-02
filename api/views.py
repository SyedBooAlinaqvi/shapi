from django import http
from django.contrib.auth import update_session_auth_hash
from django.http import response
from django.http.response import HttpResponse, HttpResponseRedirect, JsonResponse
from django.shortcuts import redirect, render
from django.views.decorators import csrf
# from django.contrib.auth.models import auth
from .models import Users, Meetings, Social_links
from django.views.decorators.csrf import csrf_exempt
from django.core import serializers
import json
import base64
from django.core.files.base import ContentFile
from uuid import uuid4
import uuid
from django.contrib.auth.hashers import check_password, make_password
from django.contrib.auth.models import User, auth
from .import views
from .helpers import send_forget_password_mail
from .helpers2 import send_change_email, send_admin_change_email
from django.contrib import messages
from django.contrib.auth.decorators import login_required


# Create your views here.
@csrf_exempt
def users(request):
    if request.method == "POST":
        name = request.POST['name']
        email = request.POST['email']
        password = make_password(request.POST['password'], None, 'md5')
        profession = request.POST['profession']
        phone_no = request.POST['phone_no']
        image = request.POST['image']
        images = base64_to_image(image)

        if Users.objects.filter(email=email).exists():
            data = {}
            data['error'] = True
            data['error_msg'] = 'Email already exists'
            return JsonResponse(data)

        if Users.objects.filter(phone_no=phone_no).exists():
            data = {}
            data['error'] = True
            data['error_msg'] = 'phone number already exists'
            return JsonResponse(data)

        if len(password) < 6:
            data = {}
            data['error'] = True
            data['error_msg'] = 'Password must be greater then six characters'
            return JsonResponse(data)

        if name.strip() == '' or email.strip() == '':
            data = {}
            data['error'] = True
            data['error_msg'] = 'Please enter Name and Email correctly'
            return JsonResponse(data)
        user = Users(name=name, email=email, password=password,
                     profession=profession, phone_no=phone_no, image=images)
        user.save()
        user = Social_links(user_id=user.pk)
        user.save()
        # user = Users.objects.get(id=user.pk)
        data = {}
        data['error'] = False
        data['success_msg'] = 'User created successfully'
        # data['users'] = serializers.serialize("json", [Users.objects.get(id=user.pk)])
        # data['users'] = json.loads(data['users'])
        return JsonResponse(data)

    else:
        return HttpResponse('Not Supported')


def base64_to_image(base64_string):
    format, imgstr = base64_string.split(';base64,')
    ext = format.split('/')[-1]
    return ContentFile(base64.b64decode(imgstr), name=uuid4().hex + "." + ext)


@csrf_exempt
def login(request):
    if request.method == 'POST':
        email = request.POST['email']
        password = request.POST['password']
        if Users.objects.filter(email=email).exists():
            user = Users.objects.get(email=email)
            user_password = user.password
            if check_password(password, user_password):
                data = {}
                data['error'] = 'False'
                data['success_msg'] = 'Successfully login!!'
                data['users'] = serializers.serialize(
                    "json", [Users.objects.get(id=user.pk)])
                data['users'] = json.loads(data['users'])
                data['links'] = serializers.serialize(
                    "json", [Social_links.objects.get(user_id=user.pk)])
                data['links'] = json.loads(data['links'])
                user_meetings = Meetings.objects.filter(user_id=user.pk)
                linkss = serializers.serialize('json', user_meetings)
                data["meetings"] = json.loads(linkss)
                return JsonResponse(data)

            else:
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Password Not Match!!'
                return JsonResponse(data)
        else:
            data = {}
            data['error'] = 'True'
            data['error_msg'] = 'Email Not Found!!'
            return JsonResponse(data)

    else:
        data = {}
        data['error'] = True
        data['error_msg'] = 'Method not supported'
        return JsonResponse(data)


@csrf_exempt
def meeting(request):
    if request.method == "POST":
        user_id_ = request.POST['user_id']
        link = request.POST['link']
        if (Users.objects.filter(id=user_id_).exists()):
            meeting_link = Meetings(link=link, user_id=user_id_)
            meeting_link.save()
            data = {}
            data['error'] = False
            data['success_msg'] = 'Meeting_link saved successfully'
            user_meetings = list(Meetings.objects.filter(
                user_id=user_id_).values().values_list('link', flat=True))
            print(user_meetings)
            # linkss = serializers.serialize('json',user_meetings)
            # print(linkss)
            # data['meetings'] = serializers.serialize("json", [ (Meetings.objects.filter(user_id=user_id_))])
            # data['meetings'] = json.loads(data['meetings'])
            data["meetings"] = user_meetings  # json.loads(linkss)
            return JsonResponse(data)
        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User_id doesnot exist please enter the valid User_id!'
            return JsonResponse(data)

    else:
        return HttpResponse('Meeting Not Supported')


@csrf_exempt
def social(request):
    if request.method == "POST":
        user_id = request.POST['user_id']
        insta = request.POST['insta']
        fb = request.POST['fb']
        linkedIn = request.POST['linkedIn']
        youtube = request.POST['youtube']
        if (Users.objects.filter(id=user_id).exists()):
            if (Social_links.objects.filter(user_id=user_id).exists()):
                links = Social_links.objects.get(user_id=user_id)
                links.insta = insta
                links.fb = fb
                links.linkedIn = linkedIn
                links.youtube = youtube
                links.save()
                data = {}
                data['error'] = False
                data['success_msg'] = 'Social_link updated successfully'
                return JsonResponse(data)
            else:
                social_link = Social_links(
                    user_id=user_id, insta=insta, fb=fb, linkedIn=linkedIn, youtube=youtube)
                social_link.save()
                data = {}
                data['error'] = False
                data['success_msg'] = 'Social_link saved successfully'
                return JsonResponse(data)

        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User_id doesnot exist please enter the valid User_id!'
            return JsonResponse(data)

    else:
        return HttpResponse('Social Not Supported')


@csrf_exempt
def update_profile(request):
    if request.method == "POST":
        name = request.POST['name']
        email = request.POST['email']
        password = request.POST['password']
        profession = request.POST['profession']
        phone_no = request.POST['phone_no']
        image = request.POST['image']
        images = base64_to_image(image)

        update = Users.objects.get(email=email)

        if Users.objects.filter(email=email).exists():

            if int(len(password)) < 6:
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Password must be contain 6 characters!!'
                return JsonResponse(data)
            elif Users.objects.filter(phone_no=phone_no).exists():
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Phone Number Already Exists!!'
                return JsonResponse(data)
                # if phone_no == update.phone_no:
                #      update.phone_no=phone_no
                # else:
                #     data = {}
                #     data['error'] = 'True'
                #     data['error_msg'] = 'Phone Number Already Exists!!'
                #     return JsonResponse(data)

            elif name != name.strip():
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Name field is required'
                return JsonResponse(data)

            elif email != email.strip():
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Email field is required'
                return JsonResponse(data)

            elif password != password.strip():
                data = {}
                data['error'] = 'True'
                data['error_msg'] = 'Password field is required'
                return JsonResponse(data)

            else:
                # update = Users.objects.get(email=email)
                update.name = name
                update.email = email
                update.password = password
                update.profession = profession
                update.phone_no = phone_no
                update.image = images
                update.save()
                # user = Users.objects.get(id=user.pk)

                data = {}
                data['error'] = 'False'
                data['success_msg'] = 'Update successfully'
                # data['users'] = serializers.serialize("json", [Users.objects.get(id=user.pk)])
                # data['users'] = json.loads(data['users'])
                return JsonResponse(data)

                # return HttpResponse(json.dumps(response), content_type="application/json")
                # return JsonResponse(json.dumps(data), content_type="application/json")
                # return JsonResponse(data)
        else:
            data = {}
            data['error'] = 'True'
            data['error_msg'] = 'Email Does Not Exists!!'
            return JsonResponse(data)

    else:
        data = {}
        data['error'] = True
        data['error_msg'] = 'Method not supported'
        return JsonResponse(data)


def base64_to_image(base64_string):
    format, imgstr = base64_string.split(';base64,')
    ext = format.split('/')[-1]
    return ContentFile(base64.b64decode(imgstr), name=uuid4().hex + "." + ext)


def change_password(request, token):
    if request.method == 'GET':
        user = Users.objects.filter(forget_password_token=token).first()
        if user:
            return render(request, 'registration/change_password.html', {'token': token, 'user_id': user.id})
        else:
            return render(request, 'registration/404page.html')

    if request.method == 'POST':
        user = Users.objects.filter(forget_password_token=token).first()
        password = request.POST['password']
        confirm_password = request.POST['confirm_password']
        user_id = request.POST['user_id']
        if user_id is None:
            messages.info(request, 'No user id found')
            return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))
        if password.strip() == '':
            messages.info(request, 'Password should not be empty')
            return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))
        if password != confirm_password:
            messages.info(request, 'Password should be same')
            return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))

        userrr = Users.objects.get(id=user_id)
        pwd = make_password(password, None, 'md5')
        userrr.password = pwd
        userrr.forget_password_token = ''
        userrr.save()
        return render(request, 'registration/password_created.html')

    return render(request, 'registration/change_password.html')


def password_created(request):
    return render(request, 'registration/password_created.html')


@csrf_exempt
def forgot_password(request):
    if request.method == 'POST':
        email = request.POST['email']
        if not Users.objects.filter(email=email).first():
            data = {}
            data['error'] = True
            data['error_msg'] = 'User not found with this email'
            return JsonResponse(data)
        user_obj = Users.objects.filter(email=email).first()
        email = user_obj.email
        token = str(uuid.uuid4())
        user_obj.forget_password_token = token
        user_obj.save()
        send_forget_password_mail(email, token)
        data = {}
        data['error'] = False
        data['success_msg'] = 'email sent!'
        return JsonResponse(data)
    else:
        return HttpResponse('Forgot Password Not Supported')


@csrf_exempt
def change_old_password(request):
    if request.method == "POST":
        user_id = request.POST['user_id']
        old_password = request.POST['old_password']
        new_password = request.POST['new_password']

        # user = Users.objects.filter(id=user_id).first()
        # print(user.password)
        # print(check_password(old_password,user.password))

        if Users.objects.get(id=user_id):

            user = Users.objects.get(id=user_id)
            if (check_password(old_password, user.password)):
                print("matched")
                if new_password != new_password.strip():
                    data = {}
                    data['error'] = 'True'
                    data['error_msg'] = 'Password field is required'
                    return JsonResponse(data)
                elif int(len(new_password)) < 6:
                    data = {}
                    data['error'] = 'True'
                    data['error_msg'] = 'Password must be contain 6 characters!!'
                    return JsonResponse(data)
                else:
                    user.password = make_password(new_password, None, 'md5')
                    user.save()
                    data = {}
                    data['error'] = False
                    data['success_msg'] = ' Your Password Changed'
                    return JsonResponse(data)
            else:
                data = {}
                data['error'] = True
                data['error_msg'] = 'Old Password Not Match!!!'
                return JsonResponse(data)

        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User Not Found!!!'
            return JsonResponse(data)

    else:
        data = {}
        data['error'] = True
        data['error_msg'] = 'Old Password Method not supported'
        return JsonResponse(data)


@csrf_exempt
def change_email(request):
    if request.method == "POST":
        user_id = request.POST['user_id']
        new_email = request.POST['new_email']
        password = request.POST['password']

        if Users.objects.get(id=user_id):
            user = Users.objects.get(id=user_id)
            if check_password(password, user.password):

                if Users.objects.filter(email=new_email).exists():
                    if user.email == new_email:
                        data = {}
                        data['error'] = True
                        data['error_msg'] = 'Email already in your use'
                        return JsonResponse(data)
                    else:
                        data = {}
                        data['error'] = True
                        data['error_msg'] = 'Email already exists'
                        return JsonResponse(data)
                else:
                    token = str(uuid.uuid4())
                    user.forget_password_token = token
                    user.save()
                    send_change_email(new_email, token)
                    data = {}
                    data['error'] = False
                    data['success_msg'] = 'Email sent successfully'
                    return JsonResponse(data)

            else:
                data = {}
                data['error'] = True
                data['error_msg'] = 'password not match'
                return JsonResponse(data)
        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User not found'
            return JsonResponse(data)
    else:
        data = {}
        data['error'] = True
        data['error_msg'] = 'Method not supported'
        return JsonResponse(data)


def user_change_email(request, token, email):
    if request.method == 'GET':
        if Users.objects.filter(forget_password_token=token).exists():
            user = Users.objects.filter(forget_password_token=token).first()
            user.email = email
            user.forget_password_token = ''
            user.save()
            return render(request, 'registration/user_change_email.html', {'token': token, 'email': email})
        else:
            return render(request, 'registration/404page.html')
    else:
        return render(request, 'registration/404page.html')


def done_password(request):
    return render(request, 'registration/done_password.html')


def myprofile(request, id):
    if request.method == "GET":
        if Users.objects.filter(id=id):
            user = Users.objects.get(id=id)
            links = Social_links.objects.get(user_id=id)
            meetings = Meetings.objects.filter(user_id=id)
            return render(request, 'registration/myprofile.html', {'user': user, 'links': links, 'meetings': meetings})

        else:
            data = {}
            data['error'] = True
            data['error_msg'] = 'User not Found!!'
            return JsonResponse(data)

    else:
        data = {}
        data['error'] = True
        data['error_msg'] = 'Method not supported'
        return JsonResponse(data)
    
    
    
    
# --------------Admin Panel----------------
def basic(request):
    return render(request, 'registration/basic.html')


@csrf_exempt
def admin_login(request):
    if request.method == 'POST':
        username = request.POST['username']
        password = request.POST['password']

        user = auth.authenticate(username=username, password=password)
        if user:

            if user.is_superuser:
                auth.login(request, user)
                return redirect('Dashboard')
        else:
            messages.info(request, 'Invalid Crendentials')
            return redirect('AdminLogin')
    else:
        return render(request, 'registration/admin_login.html')


@login_required
def dashboard(request):
    users = Users.objects.all().order_by('-id')
    return render(request, 'registration/dashboard.html', {'users':users})


# def graph(request):
#     month_names = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
#     current_year = True
#     month = now.month
#     year = now.year
#     print(month)
#     print(year)
#     result = []
#     i = 0
#     data = []
#     while(i < 12):
#         result = (month-i)-1
#         if result < 0:
#             current_year = False
#             result = month-i-1+12
#             data = month_names[result]+''+(str(year-1))
            
#             print(data)
#         else:
#             data = month_names[result] +''+ str(year)
#             print(data)
#         i=i+1
#     return HttpResponse('1')


# Graph

from django.db.models import Q
import datetime
now = datetime.datetime.now()
@csrf_exempt
def RegisterationChart(request):
    month_names = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    labels = []
    users_count = []
    thisYear = True
    current_date = datetime.date.today()
    current_month = current_date.month
    current_year = current_date.year
    i=0
    while i<12:
        month = (current_month-i)-1
        if month < 0:
            month = month+12
            thisYear = False
        if thisYear == True:
            date = month_names[month] +' '+ str(current_year)
            users_reg_count = Users.objects.filter(Q(created_at__year=current_year) & Q(created_at__month=month+1)).count()
            users_count.append(str(users_reg_count))

        else:
            date = month_names[month] +' '+str(current_year-1)
            users_reg_count = Users.objects.filter(Q(created_at__year=current_year-1) & Q(created_at__month=month+1)).count()
            users_count.append(str(users_reg_count))

        i = i+1
        labels.append(date)
    
    return JsonResponse({'months': labels, 'users_count': users_count}, safe=False)





@login_required
def user_list(request):
    users = Users.objects.all()
    return render(request, 'registration/user_list.html', {'users': users})


@login_required
def user_detail(request, pk):
    users = Users.objects.filter(id=pk)
    links = Social_links.objects.filter(user_id=pk)
    meetings = Meetings.objects.filter(user_id=pk)
    return render(request, 'registration/user_detail.html', {'users': users, 'links': links, 'meetings': meetings})


@login_required
def user_delete(request, pk):
    user = Users.objects.filter(id=pk)
    user.delete()
    links = Social_links.objects.filter(user_id=pk)
    links.delete()
    meetings = Meetings.objects.filter(user_id=pk)
    meetings.delete()
    return redirect('ListOfUsers')


@login_required
def admin_logout(request):
    auth.logout(request)
    return redirect('AdminLogin')


@csrf_exempt
def admin_forgot_pwd(request):
    if request.method == 'POST':
        email = request.POST['email']
        user_obj = User.objects.filter(is_superuser=True).first()
        if user_obj.email == email:
            send_admin_change_email(email)
            messages.info(request, 'Email Sent!')
            return redirect('AdminForgotPwd')
        else:
            messages.info(request, 'Enter Valid Email')
            return redirect('AdminForgotPwd')
    else:
        return render(request, 'registration/admin_forgot_pwd.html')


def admin_forgot_change(request, email):
    if request.method == 'GET':
        superusers = User.objects.get(is_superuser=True)
        if superusers:
            return render(request, 'registration/admin_forgot_change.html', {'email': email})
        else:
            return render(request, 'registration/404page.html')

    if request.method == 'POST':
        superusers = User.objects.get(is_superuser=True)
        password = request.POST['password']
        confirm_password = request.POST['confirm_password']
        if len(password) < 6:
            messages.info(
                request, 'Password should not be less than 6 characters')
            return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))

        if password.strip() == '':
            messages.info(request, 'Password should not be empty')
            return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))
        if password != confirm_password:
            messages.info(request, 'Password should be same')
            return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))

        pwd = make_password(password, None, 'md5')
        superusers.password = pwd
        superusers.save()
        messages.info(request, 'Password Changed Successfully')
        return HttpResponseRedirect(request.META.get('HTTP_REFERER', '/'))


    return render(request, 'registration/admin_forgot_change.html')


@login_required
@csrf_exempt
def admin_change_pwd(request):
    superusers = User.objects.get(is_superuser=True)

    if request.method == 'POST':
        old_password = request.POST['old_password']
        new_password = request.POST['new_password']
        confirm_password = request.POST['confirm_password']
        superusers = User.objects.get(is_superuser=True)
        if check_password(old_password, superusers.password):
            if int(len(new_password)) < 6:
                messages.info(
                    request, 'Password Must Contains Six Characters!!')
                return redirect('AdminChangePwd')
            elif new_password == confirm_password:
                super_pwd = make_password(new_password, None, 'md5')
                superusers.password = super_pwd
                superusers.save()
                update_session_auth_hash(request,superusers)
                messages.info(request, 'Password Changed!!')
                return redirect('AdminChangePwd')
            else:
                messages.info(request, 'Password Did Not Match!!')
                return redirect('AdminChangePwd')
        else:
            messages.info(request, 'Old Password is Invalid!!')
            return redirect('AdminChangePwd')

    return render(request, 'registration/admin_change_pwd.html')



    