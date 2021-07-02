



from django.core.mail import send_mail
from django.template.loader import render_to_string
from django.utils.html import strip_tags
from django.conf import settings
from django.template import loader


def send_forget_password_mail(email, token):
    link = 'http://127.0.0.1:8000/api/change_password/'+token
    # subject = 'your forget password link'
    # message = f'Hi , Click on the link to reset your password '+ link 
    # email_from = settings.EMAIL_HOST_USER
    # recipient_list = [email]
    # send_mail(subject, message, email_from, recipient_list)
    # return True
    
    subject = 'your forget password link'
    html_message = render_to_string('registration/mail_template.html', {'link': link})
    plain_message = strip_tags(html_message)
    email_from = settings.EMAIL_HOST_USER
    recipient_list = [email]
    send_mail(subject, plain_message, email_from, recipient_list, html_message=html_message)
    return True