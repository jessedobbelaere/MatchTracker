//
//  SettingsController.m
//  MatchTrackerApp
//
//  Created by Jesse on 7/12/12.
//  Copyright (c) 2012 Jesse. All rights reserved.
//

#import "SettingsController.h"

@interface SettingsController ()

@end

@implementation SettingsController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    // Quick dialog example
    self.root = [[QRootElement alloc] init];
    self.root.title = @"Hello World";
    self.root.grouped = YES;
    QSection *section = [[QSection alloc] init];
    QLabelElement *label = [[QLabelElement alloc] initWithTitle:@"Hello" Value:@"world!"];
    
    [self.root addSection:section];
    [section addElement:label];
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
